<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Delights\Mtn\MtnMomoServiceProvider;
use Delights\Mtn\Products\Collection;
use Delights\Sage\SageEvolution;
use App\Models\Mtn;
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
use App\Models\Magazine;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;

class MtnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mtns = Mtn::all();

        return view('admin.mtn-payments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testMtn()
    {
        try {
            $collection = new Collection();
            
            $transactionId = Carbon::now()->timestamp;
            $momoTransactionId = $collection->requestToPay($transactionId, '256775392597', 510);

            $transtatus = $collection->getTransactionStatus($momoTransactionId);

            Log::info($momoTransactionId);
            Log::info($transtatus);

            //dd($momoTransactionId);
            dd($transtatus);
        } catch(CollectionRequestException $e) {
            do {
                printf("\n\r%s:%d %s (%d) [%s]\n\r", 
                    $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(), get_class($e));
            } while($e = $e->getPrevious());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        try {
            $customer = User::findOrFail(Session::get('customer_id'));

            $currency = Session::get('currency');
            $amount = Session::get('amount');
            $orderId = Session::get('referenceId');
            $invoiceNo = $orderId;
            
            $currency = "UGX";
            $amount = $amount;
        
            Session::put('user_currency', $currency);
            Session::put('user_amount', $amount);

            $msisdn = ltrim($customer->phone_no, '0') ? '256'.ltrim($customer->phone_no, '0') : $customer->phone_no;
            $msisdn = ltrim($customer->phone_no, '+') ? : $customer->phone_no; 

            $collection = new Collection();
            
            $transactionId = Carbon::now()->timestamp;
            $momoTransactionId = $collection->requestToPay($transactionId, $msisdn, $amount);

            $transtatus = $collection->getTransactionStatus($momoTransactionId);

            Log::info($momoTransactionId);
            Log::info($transtatus);

            // Store in payment data in database
            Mtn::create([
                'user_id' => $customer->id,
                'currency' => $currency,
                'amount' => $amount,
                'reference' => $orderId,
                'access_token' => $momoTransactionId,
                'product' => 'Collection',
            ]);

            return redirect('/');
        } catch(CollectionRequestException $e) {
            do {
                printf("\n\r%s:%d %s (%d) [%s]\n\r", 
                    $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(), get_class($e));
            } while($e = $e->getPrevious());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mtn  $payment
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        $currency = Session::get('user_currency');
        $amount = Session::get('user_amount');
        $orderId = Session::get('referenceId');
        $user_id = Session::get('customer_id');
        $customer = User::findorFail($user_id);

        $mtnStatus = $request->status;
        if($mtnStatus == 'FAILED') { 
            return redirect('subscribe/plan')->with('info', 'Failed transaction. Not all parameters fulfilled. Either the phone number is wrong or you have insufficient funds.');
        }
        elseif($mtnStatus == 'PENDING') { 
            return redirect('subscribe/plan')->with('info', 'Pending: Transaction awaiting confirmation.');
        }
        elseif($mtnStatus == 'SUCCESS') { 
            $msisdn_id = isset($request->payer) ? $request->payer['partyId'] : null; 
            $payment = Mtn::where('reference', $orderId)->update(['msisdn_id' => $msisdn_id, 'txncd' => $request->externalId, 'status' => 'verified']);

            Order::where('reference', $orderId)->update(['status' => 'verified']);

            Subscription::where('reference', $orderId)->update(['status' => 'paid']);

            CartOrder::where('reference', $orderId)->update(['status' => 'verified']);

            // $amounts = [];
            // $issues = [];
            // $quantity = [];
            // $lines = [];
            // $transaction = "";
            // $subscription = Subscription::where('reference', $orderId)->first();
            // $cartOrder = CartOrder::where('reference', $orderId)->first();
            // if($cartOrder != null) {
            //     $transaction = "Cart Order";
            //     $amounts = $cartOrder->SubIssuesAmount();
            //     $issues = $cartOrder->SubIssuesItemCode();
            //     $quantity = $cartOrder->SubIssuesQuantity();

            //     $counts = count($issues);
            //     foreach($counts as $key => $count) {
            //         array_push($lines, ["StockCode" => (string)$issues[$key], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (double)$quantity[$key], "ToProcess" => (double)$quantity[$key], "UnitPrice" => (double)$amounts[$key]]);
            //     }
            // }
            // else {
            //     $transaction = "Subscription";
            //     $amounts = $subscription->SubIssuesAmount();
            //     $issues = $subscription->SubIssuesItemCode();
            //     $quantity = $subscription->SubIssuesQuantity();

            //     $lines = [["StockCode" => (string)$issues[0], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (double)$quantity[0], "ToProcess" => (double)$quantity[0], "UnitPrice" => (double)$amounts[0]], ["StockCode" => (string)$issues[1], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (double)$quantity[1], "ToProcess" => (double)$quantity[1], "UnitPrice" => (double)$amounts[1]], ["StockCode" => (string)$issues[2], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (double)$quantity[2], "ToProcess" => (double)$quantity[2], "UnitPrice" => (double)$amounts[2]], ["StockCode" => (string)$issues[3], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (double)$quantity[3], "ToProcess" => (double)$quantity[3], "UnitPrice" => (double)$amounts[3]]];
            // }
            // $sage = new SageEvolution();
            // $response = $sage->postTransaction('SalesOrderProcessInvoice', (object)["quote" =>["CustomerAccountCode" => $customer->customer_code, "OrderDate" => "/Date(".str_pad(Carbon::now()->timestamp, 13, '0', STR_PAD_RIGHT)."+0300)/", "InvoiceDate" => "/Date(".str_pad(Carbon::now()->timestamp, 13, '0', STR_PAD_RIGHT)."+0300)/", "Lines" => $lines,"FinancialLines" => []]]);

            // // Save invoice data
            // $code = $issues[0];
            // $inventoryTransaction = $sage->getTransaction('InventoryTransactionListByItemCode?Code='.$code.'&OrderBy=1&PageNumber=1&PageSize=5000000');
            // $xml = simplexml_load_string($inventoryTransaction);
            // $json = json_encode($xml);
            // $responseInvoice = json_decode($json, true);
            // $OrderNo = "";
            // $InvoiceNo = "";
            // $InvoiceDate = "";
            // foreach($responseInvoice['InventoryTransactionDto'] as $key => $value) 
            // {
            //     if(end($responseInvoice['InventoryTransactionDto']) == $value) {
            //         $OrderNo = $value['OrderNum'];
            //         $InvoiceNo = $value['Reference'];
            //         $InvoiceDate = Carbon::parse($value['Date']);
            //     }
            // }

            //start of changes
            $invoiceID = "";
            $transaction = "";
            $amounts = [];
            $issues = [];
            $quantity = [];
            $subscription = Subscription::where('reference', $orderId)->first();
            $cartOrder = CartOrder::where('reference', $orderId)->first();

            if ($cartOrder != null) {
                $invoiceID = $cartOrder->id;
                $transaction = "Cart Order";
                $amounts = $cartOrder->SubIssuesAmount();
                $issues = $cartOrder->SubIssuesItemCode();
                $quantity = $cartOrder->SubIssuesQuantity();
            } else {
                $invoiceID = Order::where('reference', $orderId)->first()->id;
                $transaction = "Subscription";
                $amounts = $subscription->SubIssuesAmount();
                $issues = $subscription->SubIssuesItemCode();
                $quantity = $subscription->SubIssuesQuantity();
            }

            $OrderNo = 'SO' . str_pad($invoiceID , 4, '0', STR_PAD_LEFT);
            $InvoiceNo = 'RCPT' . str_pad($invoiceID , 4, '0', STR_PAD_LEFT);
            //end of changes

            $invoice = Invoice::create([
                'user_id' => $customer->id,
                'reference' => $orderId,
                'discount' => "0",
                'transaction' => $transaction,
                'sales_order_no' => $OrderNo,
                'invoice_no' => $InvoiceNo,
                'invoice_date'=> Carbon::now(),
                'currency' => $currency
            ]);
            $counts = count($issues);
            foreach($issues as $key => $count) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $amounts[$key],
                    'issue' => Magazine::whereItemCode($issues[$key])->value('issue_no'),
                    'quantity' => $quantity[$key]
                ]);
            }

            $invoiceData = Invoice::with('user', 'items')->whereReference($orderId)->first()->toArray();
            $pdf = PDF::loadView('invoice.invoicepdf', $invoiceData);
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
            
            return redirect('/user/profile')->with('message', 'Your MTN payment has been received, wait for confirmation');
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

        return redirect('subscribe/plan')->with('info', 'Your MTN payment failed! Try again later.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mtn  $mtn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mtn $payment)
    {
        $payment->delete();

        return back();
    }
}
