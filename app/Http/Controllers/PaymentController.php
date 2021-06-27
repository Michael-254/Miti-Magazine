<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Delights\Ipay\Cashier;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\Amount;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Session;
use Delights\Sage\SObjects\BankAccount;
use Delights\Sage\SObjects\Contact;
use Delights\Sage\SObjects\ContactPayment;
use Delights\Sage\SObjects\LedgerAccount;
use Delights\Sage\SObjects\SalesInvoice;

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
            Cashier::CHANNEL_AIRTEL,
            Cashier::CHANNEL_EQUITY,
            Cashier::CHANNEL_MOBILE_BANKING,
            Cashier::CHANNEL_DEBIT_CARD,
            Cashier::CHANNEL_CREDIT_CARD,
        ];
        
        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $currency = SubscriptionPlan::findOrFail($plan_id)->currency();
        $amount = Amount::whereSubscriptionPlanId($plan_id)->value($plan_type);
        $orderId = Session::get('referenceId');
        $invoiceNo = $orderId;
        
        if ($currency == '€') {
            $amount = $amount;
        }
        elseif ($currency == 'TSh') {
            $amount = round($amount/21);
        }
        elseif ($currency == 'UGX') {
            $amount = round($amount/33);
        }
        else {
            $amount = round($amount*128);
        }

        // Store in payment data in database
        $customer = User::findOrFail(Session::get('customer_id'));
        Payment::create([
            'user_id' => $customer->id,
            'currency' => 'KES',
            'amount' => $amount,
            'reference' => $orderId
        ]);

        $response = $cashier
            ->usingChannels($transactChannels)
            ->usingVendorId(env('IPAY_VENDOR_ID'), env('IPAY_VENDOR_SECRET'))
            ->withCallback(env('APP_URL').'ipay/callback')
            ->withCustomer('0717606015', $customer->email, false)
            ->transact($amount, $orderId, $invoiceNo);

        return $response;
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
        // Handle iPay callback

        // Sage
        $this->contact    = (new Contact($this->api, [
            "name"             => "John Doe",
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
            ], "invoice_lines"      => [
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
        $this->assertEquals(110.0, $freshInvoice->total_paid);
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
