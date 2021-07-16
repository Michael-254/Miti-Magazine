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
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Delights\Sage\SageEvolution;

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
            $amount = round($amount/100);
        }
        elseif ($currency == 'TSh') {
            $currency = "USD";
            $amount = round($amount/2319);
        }
        elseif ($currency == 'UGX') {
            $currency = "USD";
            $amount = round($amount/3556);
        }
        else {
            $currency = "EUR";
        }
        Session::put('user_currency', $currency);
        Session::put('user_amount', $amount);

        $order = $provider->createOrder([
            "intent"=> "CAPTURE",
            "purchase_units"=> [
                0 => [
                    "reference_id" => $referenceId,
                    "amount"=> [
                        "currency_code"=> $currency,
                        "value"=> $amount
                    ]
                ]
            ],
            'application_context' => [
                 'cancel_url' => env('APP_URL').'/paypal/cancel',
                 'return_url' => env('APP_URL').'/paypal/success'
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
		
        // Login the user
        Auth::login($customer);
		
        return redirect('/user/profile')->with('ok', 'Your Paypal payment has been received, wait for confirmation');
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
            Order::where('reference', $$payment->reference)->update(['status' => 'verified']);

            Subscription::where('reference', $$payment->reference)->update(['status' => 'paid']);

            CartOrder::where('reference', $$payment->reference)->update(['status' => 'paid']);

            $sage = new SageEvolution();
            $response = $sage->postTransaction('SalesOrderProcessInvoice', '{"salesOrder":{"CustomerAccountCode":'.$customer->customer_code.',"OrderDate":'.Carbon::now()->format('m/d/Y').',"InvoiceDate":'.Carbon::now()->format('m/d/Y').',"DocumentLines":[{"StockCode":"ISS001","TaxCode":"1","Quantity":1.00,"ToProcess":1.00,"UnitPrice":200.00},{"StockCode":"ISS001","TaxCode":"1","Quantity":1.00,"ToProcess":1.00,"UnitPrice":200.00},{"StockCode":"ISS001","TaxCode":"1","Quantity":1.00,"ToProcess":1.00,"UnitPrice":200.00},{"StockCode":"ISS001","TaxCode":"1","Quantity":1.00,"ToProcess":1.00,"UnitPrice":200.00}],"DocumentFinancialLines":[{"AccountCode":"Rent","TaxCode":"1","Quantity":1.00,"ToProcess":1.00,"UnitPrice":200.00}]}}');

            // Send email with invoice
        }
        else {
            Order::where('reference', $payment->reference)->update(['status' => 'failed']);

            Subscription::where('reference', $$payment->reference)->update(['status' => 'failed']);
        }
    }
}
