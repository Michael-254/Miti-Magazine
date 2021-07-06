<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Delights\Ipay\Cashier;
use Delights\Sage\SageEvolution;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Shipping;
use App\Models\Amount;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();

        return view('admin.ipay-payments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        $cashier = new Cashier();

        $transactChannels = [
            Cashier::CHANNEL_MPESA,
            Cashier::CHANNEL_BONGA,
            Cashier::CHANNEL_AIRTEL,
            cashier::CHANNEL_EQUITY,
            cashier::CHANNEL_MOBILE_BANKING,
            cashier::CHANNEL_DEBIT_CARD,
            cashier::CHANNEL_CREDIT_CARD,
            cashier::CHANNEL_MKOPO_RAHISI,
            cashier::CHANNEL_SAIDA,
            cashier::CHANNEL_ELIPA,
            cashier::CHANNEL_UNIONPAY,
            cashier::CHANNEL_MVISA,
            cashier::CHANNEL_VOOMA,
            cashier::CHANNEL_PESAPAL,
        ];
        
        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $currency = SubscriptionPlan::findOrFail($plan_id)->currency();
        $amount = Amount::whereSubscriptionPlanId($plan_id)->value($plan_type);
        $orderId = Session::get('referenceId');
        $invoiceNo = $orderId;
        
        if ($currency == 'KSh') {
            $currency = "KES";
            $amount = $amount;
        }
        elseif ($currency == 'TSh') {
            $currency = "KES";
            $amount = round($amount/21);
        }
        elseif ($currency == 'UGX') {
            $currency = "KES";
            $amount = round($amount/33);
        }
        else {
            $currency = "KES";
            $amount = round($amount*128);
        }
        Session::put('user_currency', $currency);
        Session::put('user_amount', $amount);

        $customer = User::findOrFail(Session::get('customer_id'));
        $fields = $cashier
            ->usingChannels($transactChannels)
            ->usingVendorId(env('IPAY_VENDOR_ID'), env('IPAY_VENDOR_SECRET'))
            ->withCallback(env('APP_URL').'/ipay/callback', env('APP_URL').'/ipay/failed')
            ->withCustomer($customer->phone_no, $customer->email, false)
            ->transact($amount, $orderId, $invoiceNo);

        // Store in payment data in database
        Payment::create([
            'user_id' => $customer->id,
            'currency' => 'KES',
            'amount' => $amount,
            'reference' => $orderId
        ]);

        return view('ipay', compact('fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        /* Response
         * http://localhost/ipay/callback?status=aei7p7yrx4ae34&txncd=PG28TZAZ0E&msisdn_id=JOHN+DOE&msisdn_idnum=254722000000&p1=&p2=&p3=&p4=&uyt=1817486427&agt=658397967&qwh=1226344355&ifd=784861590&afd=1521439284&poi=78179582&id=1625230215&ivm=1625230215&mc=5.00&channel=MPESA
        */

        $currency = Session::get('user_currency');
        $amount = Session::get('user_amount');
        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $orderId = Session::get('referenceId');
        $user_id = Session::get('customer_id');
        $customer = User::findorFail($user_id);

        $ipayStatus = $request->status;
        if($ipayStatus == 'fe2707etr5s4wq') { 
            return redirect('subscribe/plan')->with('info', 'Failed transaction. Not all parameters fulfilled. A notification of this transaction sent to the merchant.');
        }
        elseif($ipayStatus == 'bdi6p2yy76etrs') { 
            return redirect('subscribe/plan')->with('info', 'Pending: Incoming Mobile Money Transaction Not found. Please try again in 5 minutes.');
        }
        elseif($ipayStatus == 'dtfi4p7yty45wq') { 
            return redirect('subscribe/plan')->with('info', 'Less: The amount that you have sent via mobile money is LESS than what was required to validate this transaction.');
        }
        elseif($ipayStatus == 'cr5i3pgy9867e1') { 
            return redirect('subscribe/plan')->with('info', 'Used: This code has been used already. Try again!.');
        }
        elseif($ipayStatus == 'eq3i7p5yt7645e') { 
            return redirect('subscribe/plan')->with('info', 'More: The amount that you have sent via mobile money is MORE than what was required to validate this transaction. (Up to the merchant to decide what to do with this transaction; whether to pass it or not)');
        }
        elseif($ipayStatus == 'aei7p7yrx4ae34') { 
            $msisdn_id = isset($request->msisdn_id) ? $request->msisdn_id : null; 
            $msisdn_idnum = isset($request->msisdn_idnum) ? $request->msisdn_idnum : null; 
            $payment = Payment::where('reference', $orderId)->update(['msisdn_id' => $msisdn_id, 'msisdn_idnum' => $msisdn_idnum, 'txncd' => $request->txncd, 'channel' => $request->channel, 'status' => 'VERIFIED']);

            Order::where('reference', $orderId)->update(['status' => 'VERIFIED']);

            Subscription::where('reference', $orderId)->update(['status' => 'VERIFIED']);

            // Handle Sage
            /* $this->contact    = (new Contact($this->api, [
                "name"             => $customer->name,
                "contact_type_ids" => ["CUSTOMER"],
            ]))->create();

            $ledgerAccount = (new LedgerAccount($this->api))
                ->where("ledger_account_type_id=SALES")->where("items_per_page=100")->where("ledger_account_classification=KE_SALES_AND_INCOMES")
                ->get()->first(function ($ledgerAccount) {
                    return str_contains($ledgerAccount->displayed_as, '70500000');
                });

            $bankAccount = (new BankAccount($this->api))
                ->get()->first(function ($bankAccount) {
                    return str_contains($bankAccount->displayed_as, '57200000');
                });

            $invoiceResource = (new SalesInvoice($this->api));
            $invoices_count  = $invoiceResource->count();

            $invoice = (new SalesInvoice($this->api, [
                "contact_id"        => $this->contact->id,
                "date"              => Carbon::now()->toDateString(),
                "invoice_number"    => $invoices_count + 1,
                "main_address"      => [
                    "name"              => "Main Address",
                    "address_line_1"    => "Moi Avenue",
                    "address_line_2"    => "",
                    "city"              => "Nairobi",
                    "region"            => "Kenya",
                    "postal_code"       => "00100",
                    "country_id"        => "KE"
                ], 
                "invoice_lines"      => [
                    [
                        "description" => "Line 1",
                        "ledger_account_id" => $ledgerAccount->id,
                        "quantity" => 2,
                        "unit_price" => 55,
                        "tax_rate_id" => "KE_NO_TAX",
                    ],
                ],
            ]))->create();
            $contactPayment = (new ContactPayment($this->api, [
                "transaction_type_id" => "CUSTOMER_RECEIPT",
                "contact_id" => $this->contact->id,
                "bank_account_id" => $bankAccount->id,
                "date" => Carbon::now()->toDateString(),
                "total_amount"  => 110.00,
                "allocated_artefacts" =>  [
                    [ 
                        'artefact_id'   =>  $invoice->id,
                        'amount'        => 110.00
                    ]
                ]
            ]))->create();

            $this->assertNotFalse($invoice->id);
            $freshInvoice = $invoiceResource->find($invoice->id);

            $this->assertNotFalse($contactPayment->id);
            $this->assertEquals($this->contact->id, $freshInvoice->contact["id"]);
            $this->assertEquals(Carbon::now()->toDateString(), $freshInvoice->date);
            $this->assertCount(1, $freshInvoice->invoice_lines);
            $this->assertEquals($invoices_count + 1, $invoiceResource->count());
            $this->assertEquals("PAID", $freshInvoice->status["id"]);
            $this->assertEquals(110.0, $freshInvoice->total_paid); */

            // Login the user
            Auth::login($customer);
            
            return redirect('/user/profile')->with('ok', 'Your iPay payment has been received, wait for confirmation');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentFailed()
    {
        return redirect('subscribe/plan')->with('info', 'Your iPay payment failed! Try again later.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sageTest(Request $request)
    {
        $sage = new SageEvolution();
        // $response = $sage->getTransaction('CustomerFind?Code=CASH');
        // $response = $sage->getTransaction('CustomerExists?Code=CASH');
        // $response = $sage->getTransaction('CustomerList?OrderBy=1&PageNumber=1&PageSize=50');
        // $response = $sage->postTransaction('CustomerInsert', (object)["client" => ["Active" => true, "Description" => "Evans Charles Wanguba", "ChargeTax" => false, "Code" => "ECW001"]]);

         $response = $sage->postTransaction('SalesOrderProcessInvoice', (object)["SalesOrder" => ["CustomerAccountCode" => "ECW001", "OrderDate" => Carbon::now()->toDateString(), "InvoiceDate" => Carbon::now()->toDateString()]]);
         
        dd($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return back();
    }
}
