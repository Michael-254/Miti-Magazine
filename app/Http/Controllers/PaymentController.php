<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Delights\Ipay\Cashier;
use Delights\Sage\SageEvolution;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\SelectedIssue;
use App\Models\Shipping;
use App\Models\Amount;
use App\Models\Order;
use App\Models\CartOrder;
use App\Models\CartItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Mail;

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
        
        $currency = Session::get('currency');
        $amount = Session::get('amount');
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
            $payment = Payment::where('reference', $orderId)->update(['msisdn_id' => $msisdn_id, 'msisdn_idnum' => $msisdn_idnum, 'txncd' => $request->txncd, 'channel' => $request->channel, 'status' => 'verified']);

            Order::where('reference', $orderId)->update(['status' => 'verified']);

            Subscription::where('reference', $orderId)->update(['status' => 'paid']);

            CartOrder::where('reference', $orderId)->update(['status' => 'verified']);

            $amounts = [];
            $issues = [];
            $quantity = [];
            $lines = [];
            $transaction = "";
            $subscription = Subscription::where('reference', $orderId)->first();
            $cartOrder = CartOrder::where('reference', $orderId)->first();
            if($cartOrder != null) {
                $transaction = "Cart Order";
                $amounts = $cartOrder->SubIssuesAmount();
                $issues = $cartOrder->SubIssuesItemCode();
                $quantity = $cartOrder->SubIssuesQuantity();

                $counts = count($issues);
                foreach($counts as $key => $count) {
                    array_push($lines, ["StockCode" => (string)$issues[$key], "TaxCode" => "1", "Quantity" => (double)$quantity[$key], "ToProcess" => (double)$quantity[$key], "UnitPrice" => (double)$amounts[$key]]);
                }
            }
            else {
                $transaction = "Subscription";
                $amounts = $subscription->SubIssuesAmount();
                $issues = $subscription->SubIssuesItemCode();
                $quantity = $subscription->SubIssuesQuantity();

                $lines = [["StockCode" => (string)$issues[0], "TaxCode" => "1", "Quantity" => (double)$quantity[0], "ToProcess" => (double)$quantity[0], "UnitPrice" => (double)$amounts[0]], ["StockCode" => (string)$issues[1], "TaxCode" => "1", "Quantity" => (double)$quantity[1], "ToProcess" => (double)$quantity[1], "UnitPrice" => (double)$amounts[1]], ["StockCode" => (string)$issues[2], "TaxCode" => "1", "Quantity" => (double)$quantity[2], "ToProcess" => (double)$quantity[2], "UnitPrice" => (double)$amounts[2]], ["StockCode" => (string)$issues[3], "TaxCode" => "1", "Quantity" => (double)$quantity[3], "ToProcess" => (double)$quantity[3], "UnitPrice" => (double)$amounts[3]]];
            }
            $sage = new SageEvolution();
            $response = $sage->postTransaction('SalesOrderProcessInvoice', (object)["quote" =>["CustomerAccountCode" => $customer->customer_code, "OrderDate" => "/Date(".str_pad(Carbon::now()->timestamp, 13, '0', STR_PAD_RIGHT)."+0300)/", "InvoiceDate" => "/Date(".str_pad(Carbon::now()->timestamp, 13, '0', STR_PAD_RIGHT)."+0300)/", "Lines" => $lines,"FinancialLines" => []]]);

            // Save invoice data
            $invoice = Invoice::create([
                'user_id' => $customer->id,
                'reference' => $orderId,
                'discount' => "0",
                'transaction' => $transaction,
                'sales_order_no' => $response['OrderNo'],
                'invoice_no' => $response['OrderNo'],
                'invoice_date'=> $response['InvoiceDate'],
                'currency' => $currency
            ]);
            $counts = count($issues);
            foreach($counts as $key => $count) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $amounts[$key],
                    'issues' => $issues[$key],
                    'quantities' => $quantity[$key]
                ]);
            }

            $pdf = PDF::loadView('invoice.invoice', $invoice);
            $data = [
                'intro'  => 'Hello '.$customer->name.',',
                'content'   => 'Your order with reference: '.$orderId.' has been well received. Kindly find attached your invoice.',
                'name' => $customer->name,
                'email' => $customer->email,
                'subject'  => 'Successful Payment for Order No. '.$orderId
            ];
            Mail::send('emails.order', $data, function($message) use ($data, $pdf) {
                $message->to($data['email'], $data['name'])
                        ->subject($data['subject'])
                        ->attachData($pdf->output(), "invoice.pdf");
            });

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
        $orderId = Session::get('referenceId');

        Order::where('reference', $orderId)->update(['status' => 'failed']);

        Subscription::where('reference', $orderId)->update(['status' => 'failed']);

        CartOrder::where('reference', $orderId)->update(['status' => 'failed']);

        return redirect('subscribe/plan')->with('info', 'Your iPay payment failed! Try again later.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sageTest(Request $request)
    {
        $position = Location::get('197.232.61.227');
        dd($position);
         $sage = new SageEvolution();
        // $response = $sage->getTransaction('CustomerFind?Code=CASH');
        // $response = $sage->getTransaction('CustomerExists?Code=CASH');
        // $response = $sage->getTransaction('CustomerList?OrderBy=1&PageNumber=1&PageSize=50');
        // $response = $sage->getTransaction('InventoryItemFind?Code=ISS001');
        // $response = $sage->getTransaction('InventoryItemList?OrderBy=1&PageNumber=1&PageSize=50');
        // $response = $sage->getTransaction('SalesOrderLoadByOrderNo?orderNo=SO0001');
        // $response = $sage->getTransaction('SalesOrderExists?orderNo=SO0001');
        // $response = $sage->postTransaction('CustomerInsert', (object)["client" => ["Active" => true, "Description" => "John Doe", "ChargeTax" => false, "Code" => "JD001"]]);
        // $response = $sage->postTransaction('InventoryItemInsert', (object)["item" => ["Code" => "ISS001"]]);
         $response = $sage->postTransaction('SalesOrderProcessInvoice', (object)["quote" =>["CustomerAccountCode" => "CASH","OrderDate" => "/Date(".str_pad(Carbon::now()->timestamp, 13, '0', STR_PAD_RIGHT)."+0300)/","InvoiceDate" => "/Date(".str_pad(Carbon::now()->timestamp, 13, '0', STR_PAD_RIGHT)."+0300)/","Lines" => [["StockCode" => "Test","TaxCode" => "1","Quantity" => 1,"ToProcess" => 1,"UnitPrice" => 200.00], ["StockCode" => "Test","TaxCode" => "1","Quantity" => 1,"ToProcess" => 1,"UnitPrice" => 200.00]],"FinancialLines" => []]]); //QuotationPlaceOrder
        
        return dd($response);
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
