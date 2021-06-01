<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\Payment;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use Cart;
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
    public function getExpressCheckout(Request $request)
    {
        // Import the namespace Srmklive\PayPal\Services\ExpressCheckout first in your controller.
        $this->provider = new ExpressCheckout;

        $userid = auth()->user()->id;
        $username = $request->name;
        $amount = $request->amount;
        $invoiceid = $request->reference;
        $request->session()->put('invoiceid', $invoiceid);
        $request->session()->put('amount', $amount);
        $carts = Cart::getContent();

        $data = [];
        $data['items'] = [];
        $total = 0;
        foreach ($carts as $key => $cart) {
            $data['items'][$key]['name'] = $cart->name;
            $data['items'][$key]['price'] = $cart->price;
            $data['items'][$key]['qty'] = $cart->quantity;

            $total += $cart->price * $cart->quantity;
        }
        
        $data['invoice_id'] = $invoiceid;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = url('express-checkout-success');
        $data['cancel_url'] = url('checkout');
        $data['total'] = $total;

        $options = [
            'SOLUTIONTYPE' => 'Sole'
        ];

        //Set Express Checkout $provider
        $response = $this->provider->addOptions($options)->setExpressCheckout($data);

        $inputs = [
            'user_id' => $userid,
            'user_name' => $username,
            'Amount' => $amount,
            'invoice' => $invoiceid,
            'token' => $response['TOKEN']
        ];
        Payment::create($inputs);

        // This will redirect user to PayPal
        return redirect($response['paypal_link']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getExpressCheckoutSuccess(Request $request)
    {
        // Import the namespace Srmklive\PayPal\Services\ExpressCheckout first in your controller.
        $this->provider = new ExpressCheckout;

        $invoiceid = $request->session()->get('invoiceid');
        $amount = $request->session()->get('amount');
        $carts = Cart::getContent();

        $data = [];
        $data['items'] = [];
        $total = 0;
        foreach ($carts as $key => $cart) {
            $data['items'][$key]['name'] = $cart->name;
            $data['items'][$key]['price'] = $cart->price;
            $data['items'][$key]['qty'] = $cart->quantity;

            $total += $cart->price * $cart->quantity;
        }
		
        $data['invoice_id'] = $invoiceid;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = url('express-checkout-success');
        $data['cancel_url'] = url('my-carts');
        $data['total'] = $total;

        $recurring = false;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');
        $cartitems = $data;

        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            if ($recurring === true) {
                $response = $this->provider->createMonthlySubscription($response['TOKEN'], 9.99, $cartitems['subscription_desc']);
                if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                    $status = 'Processed';
                } else {
                    $status = 'Invalid';
                }
            } else {
                // Perform transaction on PayPal
            }

            Payment::whereToken($token)->update(['PayerId' => $PayerID]);

            $payment_status = $this->provider->doExpressCheckoutPayment($cartitems, $token, $PayerID);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];

            Cart::clear();
            $request->session()->forget('invoiceid');
            $request->session()->forget('amount');
            
            // Mail order request to Admin
            $role = Role::whereSlug('admin')->first();
            $users = User::whereRoleId($role->id)->get();
            foreach($users as $user) {
                $data = [
                    'title'  => 'Order by '.$username,
                    'intro'  => $user->name,
                    'content'   => 'Payment for Order Reference:<strong>'.$request->session()->get('invoiceid').'</strong> has been made awaiting confirmation.',
                'name' => $user->name,
                'email' => $user->email,
                'subject' => 'Order payment.'
                ];
                Mail::send('emails.email', $data, function($message) use ($data) {
                    $message->to($data['email'], $data['name'])
                            ->subject($data['subject']);
                });
            }
            
            //Mail customer
            $userName = 'Miti Customer';
            $userEmail = 'miticustomer@gmail.com';
            $data = [
                'title'  => 'Order Reference:<strong>'.$request->session()->get('invoiceid').'</strong>',
                'intro'  => $userName,
                'content'   => 'Payment for Order Reference:<strong>'.$request->session()->get('invoiceid').'</strong> has been successfully made awaiting confirmation.',
            'name' => $userName,
            'email' => $userEmail,
            'subject' => 'Order payment'
            ];
            Mail::send('emails.email', $data, function($message) use ($data) {
                $message->to($data['email'], $data['name'])
                        ->subject($data['subject']);
            });

            return redirect('/')->with('ok', 'Your Paypal payment has been received, wait for confirmation');
        }

        return redirect('/')->with('ok', 'An error occured!');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postNotify(Request $request)
    {
        if (!($this->provider instanceof ExpressCheckout)) {
            $this->provider = new ExpressCheckout();
        }

        $post = [
            'cmd' => '_notify-validate',
        ];
        $data = $request->all();
        foreach ($data as $key => $value) {
            $post[$key] = $value;
        }

        $response = (string) $this->provider->verifyIPN($post);

        Payment::whereToken($request->input('token'))->update(['payload' => json_encode($post), 'status' => $response]);

        if ($response == 'VERIFIED') {
            $reference = Payment::whereToken($request->input('token'))->value('invoice');

            // Update order status
            Order::whereReference($reference)->update(['status' => 'paid']);
            
            // Mail order request to Admin
            $userName = 'Miti Customer';
            $userEmail = 'miticustomer@gmail.com';
            $role = 1;
            $users = User::whereRoleId($role)->get();
            foreach($users as $user) {
                $data = [
                    'title'  => 'Order by '.$userName,
                    'intro'  => $user->name,
                    'content'   => 'Payment confirmation for Order Reference:<strong>'.$reference.'</strong> has been successfully received. Proceed to ship the products.',
                'name' => $user->name,
                'email' => $user->email,
                'subject' => 'Order payment received'
                ];
                Mail::send('emails.email', $data, function($message) use ($data) {
                    $message->to($data['email'], $data['name'])
                            ->subject($data['subject']);
                });
            }
            
            //Mail customer
            $data = [
                'title'  => 'Order Reference:<strong>'.$reference.'</strong>',
                'intro'  => $userName,
                'content'   => 'Payment confirmation for Order Reference:<strong>'.$reference.'</strong> has been successfully received. You will be contacted as soon as your order is dispatched for delivery.',
            'name' => $userName,
            'email' => $userEmail,
            'subject' => 'Order payment received'
            ];
            Mail::send('emails.email', $data, function($message) use ($data) {
                $message->to($data['email'], $data['name'])
                        ->subject($data['subject']);
            });
        }
        else {
            $reference = Payment::whereToken($request->input('token'))->value('invoice');
            // Update order status
            Order::whereReference($reference)->update(['status' => 'failed']);
            
            // Mail order request to Admin
            $userName = 'Miti Customer';
            $userEmail = 'miticustomer@gmail.com';
            $role = 1;
            $users = User::whereRoleId($role)->get();
            foreach($users as $user) {
                $data = [
                    'title'  => 'Order by '.$userName,
                    'intro'  => $user->name,
                    'content'   => 'Payments for Order Reference:<strong>'.$reference.' failed.',
                'name' => $user->name,
                'email' => $user->email,
                'subject' => 'Order payment failed'
                ];
                Mail::send('emails.email', $data, function($message) use ($data) {
                    $message->to($data['email'], $data['name'])
                            ->subject($data['subject']);
                });
            }
            
            //Mail customer
            $data = [
                'title'  => 'Order Reference:<strong>'.$reference.'</strong>',
                'intro'  => $userName,
                'content'   => 'Payments for Order Reference:<strong>'.$reference.' failed.',
            'name' => $userName,
            'email' => $userEmail,
            'subject' => 'Order payment failed'
            ];
            Mail::send('emails.email', $data, function($message) use ($data) {
                $message->to($data['email'], $data['name'])
                        ->subject($data['subject']);
            });
        }
    }
}
