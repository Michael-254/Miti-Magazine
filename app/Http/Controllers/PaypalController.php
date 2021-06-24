<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Paypal as Payment;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use Session;
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

        return view('back.payments', compact('payments'));
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
        $provider->setAccessToken($provider->getAccessToken());

        $order = $provider->createOrder([
            "intent"=> "CAPTURE",
            "purchase_units"=> [
                0 => [
                    "reference_id" => '1234567',
                    "amount"=> [
                        "currency_code"=> "USD",
                        "value"=> "100.00"
                    ]
                ]
            ],
            'application_context' => [
                 'cancel_url' => env('APP_URL').'/paypal/cancel',
                 'return_url' => env('APP_URL').'/paypal/success'
            ]
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
        $provider->setAccessToken($provider->getAccessToken());

        $order_id = Session::get('payapal_order_id');
        $provider->capturePaymentOrder($order_id);

        return redirect('/')->with('ok', 'Your Paypal payment has been received, wait for confirmation');
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
        //
    }
}
