<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Paypal as Payment;
use App\Models\SubscriptionPlan;
use App\Models\Shipping;
use App\Models\Amount;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Delights\Sage\SObjects\BankAccount;
use Delights\Sage\SObjects\Contact;
use Delights\Sage\SObjects\ContactPayment;
use Delights\Sage\SObjects\LedgerAccount;
use Delights\Sage\SObjects\SalesInvoice;
use Delights\PayPal\Services\AdaptivePayments;

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
        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $order_id = Session::get('paypal_order_id');
        $user_id = Session::get('customer_id');
        $customer = User::findorFail($user_id);

        $provider->capturePaymentOrder($order_id);

        $paypalToken = $request->get('token');
        $PayerID = $request->get('PayerID');
        $payment = Payment::where('paypal_order_id', $order_id)->update(['token' => $paypalToken, 'PayerId' => $PayerID]);

        // Handle Sage
        /* $this->contact    = (new Contact($this->api, [
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
        $this->assertEquals(110.0, $freshInvoice->total_paid); */
		
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
            Order::where('reference', $$payment->reference)->update(['status' => 'VERIFIED']);

            Subscription::where('reference', $$payment->reference)->update(['status' => 'VERIFIED']);
        }
        else {
            Order::where('reference', $payment->reference)->update(['status' => 'FAILED']);

            Subscription::where('reference', $$payment->reference)->update(['status' => 'FAILED']);
        }
    }
}
