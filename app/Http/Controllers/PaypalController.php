<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Paypal as Payment;
use App\Models\SubscriptionPlan;
use App\Models\Amount;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Mail;
use Illuminate\Support\Facades\Auth;

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

        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $currency = SubscriptionPlan::findOrFail($plan_id)->currency();
        $amount = Amount::whereSubscriptionPlanId($plan_id)->value($plan_type);
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

        Session::put('payapal_order_id', $order['id']);

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

        $order_id = Session::get('payapal_order_id');
        $provider->capturePaymentOrder($order_id);

        $paypalToken = $request->get('token');
        $PayerID = $request->get('PayerID');
        Payment::where('paypal_order_id', $order_id)->update(['token' => $paypalToken, 'PayerId' => $PayerID]);
		
        $user_id = Session::get('customer_id');
        $paidUser = User::findorFail($user_id);
        Auth::login($paidUser);
		
        return redirect('/user/profile')->with('ok', 'Your Paypal payment has been received, wait for confirmation');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentCancel(Request $request)
    {
        return redirect('/')->with('info', 'Your Paypal payment was canceled!');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postNotify(Request $request)
    {
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
        Payment::whereToken($paypalToken)->update(['payload' => json_encode($post), 'status' => $response]);

        if ($response == 'VERIFIED') {
            // Update order with success payment
        }
        else {
            // Update order with failed payment
        }
    }
}
