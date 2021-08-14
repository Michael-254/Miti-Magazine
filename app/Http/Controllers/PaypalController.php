<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Paypal as Payment;
use App\Models\SubscriptionPlan;
use App\Models\Shipping;
use App\Models\Amount;
use App\Models\Order;
use App\Models\CartOrder;
use App\Models\CartItem;
use App\Models\ExchangeRate;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\Role;
use App\Models\Magazine;
use App\Models\Subscription;
use App\Models\SelectedIssue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Delights\Sage\SageEvolution;
use PDF;
use Mail;

class PaypalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();

        return view('admin.paypal-payments', compact('payments'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentProcess(Request $request)
    {
        \PayPal::setProvider();
        $provider = \PayPal::getProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $currency = Session::get('currency');
        $amount = Session::get('amount');
        $referenceId = Session::get('referenceId');

        // Supported currency
        // AUD, BRL, CAD, CNY, CZK, DKK, EUR, HKD, HUF, ILS, JPY, MYR, MXN, TWD, NZD, NOK, PHP, PLN, GBP, RUB, SGD, SEK, CHF, THB, USD

        if ($currency == 'KSh') {
            $currency = "USD";
            $rate = ExchangeRate::where('currency', '=', 'USD')->value('KSHS_USD');
            $amount = round($amount / $rate);
        } elseif ($currency == 'TSh') {
            $currency = "USD";
            $rate = ExchangeRate::where('currency', '=', 'USD')->value('TSH');
            $amount = round($amount / $rate);
        } elseif ($currency == 'UGX') {
            $currency = "USD";
            $rate = ExchangeRate::where('currency', '=', 'USD')->value('UGX');
            $amount = round($amount / $rate);
        } else {
            $currency = "USD";
        }
        Session::put('user_currency', $currency);
        Session::put('user_amount', $amount);

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "reference_id" => $referenceId,
                    "amount" => [
                        "currency_code" => $currency,
                        "value" => $amount
                    ]
                ]
            ],
            'application_context' => [
                'cancel_url' => env('APP_URL') . '/paypal/cancel',
                'return_url' => env('APP_URL') . '/paypal/success'
            ]
        ]);


        Payment::create([
            'user_id' => Session::get('customer_id'),
            'currency' => $currency,
            'amount' => $amount,
            'reference' => $referenceId,
            'paypal_order_id' => $order['id']
        ]);

        Session::put('paypal_order_id', $order['id']);

        return redirect($order['links'][1]['href'])->send();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentSuccess(Request $request)
    {
        \PayPal::setProvider();
        $provider = \PayPal::getProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $currency = Session::get('user_currency');
        $amount = Session::get('user_amount');
        $order_id = Session::get('paypal_order_id');
        $user_id = Session::get('customer_id');
        $customer = User::findorFail($user_id);

        $provider->capturePaymentOrder($order_id);

        $paypalToken = $request->get('token');
        $PayerID = $request->get('PayerID');
        $payment = Payment::where('paypal_order_id', $order_id)->update(['token' => $paypalToken, 'PayerId' => $PayerID]);

        $data = [
            'intro'  => 'Dear ' . $customer->name . ',',
            'content'   => 'Your order  has been well received. Kindly go to your paypal account and approve the payment.',
            'name' => $customer->name,
            'email' => $customer->email,
            'subject'  => 'Successful Payment for Order No. ' . $payment->reference
        ];
        Mail::send('emails.paypal-mail', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])
                ->subject($data['subject']);
        });

        // Login the user
        Auth::login($customer);

        return redirect('/user/profile')->with('message', 'Your Paypal payment has been received, wait for confirmation');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentCancel(Request $request)
    {
        return redirect('subscribe/plan')->with('info', 'Your Paypal payment was canceled!');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postNotify(Request $request)
    {
        Log::info($request->all());

        \PayPal::setProvider();
        $provider = \PayPal::getProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $post = [
            'cmd' => '_notify-validate',
        ];
        $data = $request->all();
        foreach ($data as $key => $value) {
            $post[$key] = $value;
        }

        $response = (string) $this->provider->verifyIPN($post);

        $paypalToken = $request->get('token');
        $payment = Payment::whereToken($paypalToken)->update(['payload' => json_encode($post), 'status' => $response]);

        if ($response == 'VERIFIED') {
            Order::where('reference', $payment->reference)->update(['status' => 'verified']);

            Subscription::where('reference', $payment->reference)->update(['status' => 'paid']);

            CartOrder::where('reference', $payment->reference)->update(['status' => 'verified']);

            $amounts = [];
            $issues = [];
            $quantity = [];
            $lines = [];
            $transaction = "";
            $subscription = Subscription::where('reference', $payment->reference)->first();
            $cartOrder = CartOrder::where('reference', $payment->reference)->first();
            if ($cartOrder != null) {
                $transaction = "Cart Order";
                $amounts = $cartOrder->SubIssuesAmount();
                $issues = $cartOrder->SubIssuesItemCode();
                $quantity = $cartOrder->SubIssuesQuantity();

                $counts = count($issues);
                foreach ($counts as $key => $count) {
                    array_push($lines, ["StockCode" => (string)$issues[$key], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (float)$quantity[$key], "ToProcess" => (float)$quantity[$key], "UnitPrice" => (float)$amounts[$key]]);
                }
            } else {
                $transaction = "Subscription";
                $amounts = $subscription->SubIssuesAmount();
                $issues = $subscription->SubIssuesItemCode();
                $quantity = $subscription->SubIssuesQuantity();

                $lines = [["StockCode" => (string)$issues[0], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (float)$quantity[0], "ToProcess" => (float)$quantity[0], "UnitPrice" => (float)$amounts[0]], ["StockCode" => (string)$issues[1], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (float)$quantity[1], "ToProcess" => (float)$quantity[1], "UnitPrice" => (float)$amounts[1]], ["StockCode" => (string)$issues[2], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (float)$quantity[2], "ToProcess" => (float)$quantity[2], "UnitPrice" => (float)$amounts[2]], ["StockCode" => (string)$issues[3], "WarehouseCode" => "MitiMagazineWH", "TaxCode" => "1", "Quantity" => (float)$quantity[3], "ToProcess" => (float)$quantity[3], "UnitPrice" => (float)$amounts[3]]];
            }
            $sage = new SageEvolution();
            $response = $sage->postTransaction('SalesOrderProcessInvoice', (object)["quote" => ["CustomerAccountCode" => $customer->customer_code, "OrderDate" => "\/Date(" . str_pad(Carbon::now()->timestamp, 13, '0', STR_PAD_RIGHT) . "+0300)\/", "InvoiceDate" => "\/Date(" . str_pad(Carbon::now()->timestamp, 13, '0', STR_PAD_RIGHT) . "+0300)\/", "Lines" => $lines, "FinancialLines" => []]]);

            // Save invoice data
            $code = $issues[0];
            $inventoryTransaction = $sage->getTransaction('InventoryTransactionListByItemCode?Code=' . $code . '&OrderBy=1&PageNumber=1&PageSize=5000000');
            $xml = simplexml_load_string($inventoryTransaction);
            $json = json_encode($xml);
            $responseInvoice = json_decode($json, true);
            $OrderNo = "";
            $InvoiceNo = "";
            $InvoiceDate = "";
            foreach ($responseInvoice['InventoryTransactionDto'] as $key => $value) {
                if (end($responseInvoice['InventoryTransactionDto']) == $value) {
                    $OrderNo = $value['OrderNum'];
                    $InvoiceNo = $value['Reference'];
                    $InvoiceDate = Carbon::parse($value['Date']);
                }
            }
            $invoice = Invoice::create([
                'user_id' => $customer->id,
                'reference' => $payment->reference,
                'discount' => "0",
                'transaction' => $transaction,
                'sales_order_no' => $OrderNo,
                'invoice_no' => $InvoiceNo,
                'invoice_date' => $InvoiceDate,
                'currency' => $payment->currency
            ]);
            $counts = count($issues);
            foreach ($issues as $key => $count) {
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
                'intro'  => 'Hello ' . $customer->name . ',',
                'content'   => 'Your order with reference: ' . $payment->reference . ' has been well received. Kindly find attached your invoice.',
                'name' => $customer->name,
                'email' => $customer->email,
                'subject'  => 'Successful Payment for Order No. ' . $payment->reference
            ];
            Mail::send('emails.order', $data, function ($message) use ($data, $pdf) {
                $message->to($data['email'], $data['name'])
                    ->subject($data['subject'])
                    ->attachData($pdf->output(), "invoice.pdf");
            });
        } else {
            Order::where('reference', $payment->reference)->update(['status' => 'failed']);

            Subscription::where('reference', $payment->reference)->update(['status' => 'failed']);

            CartOrder::where('reference', $payment->reference)->update(['status' => 'failed']);
        }
    }
}
