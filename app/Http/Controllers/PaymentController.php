<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Delights\Ipay\Cashier;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $response = $cashier
            ->usingChannels($transactChannels)
            ->usingVendorId(env('IPAY_VENDOR_ID'), env('IPAY_VENDOR_SECRET'))
            ->withCallback('http://yourcallback.com')
            ->withCustomer('0722000000', 'demo@example.com', false)
            ->transact(10, 'your order id', 'your order secret');

        dd($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
