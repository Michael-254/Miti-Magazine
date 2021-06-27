<?php

namespace App\Http\Controllers;

use App\Models\Amount;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShippingController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'payment_method' => 'required',
            'phone_no' => 'required'
        ]);

        $customer = User::updateOrCreate([
            'email' => $request->email,
        ], [
            'name' => $request->name,
            'phone_no' => $request->phone_no,
            'country' => $request->country,
            'company' => $request->company,
            'password' => bcrypt('123456'),
        ]);
        Session::put('customer_id', $customer->id);

        $address = Shipping::updateOrCreate([
            'user_id' => $customer->id,
        ], [
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'apartment' => $request->apartment,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $referenceId = Carbon::now()->timestamp;
        Session::put('referenceId', $referenceId);

        Order::create([
            'user_id' => $customer->id, 'subscription_plan_id' => $plan_id, 'reference' => $referenceId, 'type' => $plan_type
        ]);

        Subscription::create([
            'user_id' => $customer->id, 'subscription_plan_id' => $plan_id, 'reference' => $referenceId,
            'start_date' => Carbon::now()->format('Y-m-d'), 'end_date' => Carbon::now()->addYear()->format('Y-m-d')
        ]);


        if ($request->payment_method == 'paypal') {
            return redirect('paypal/checkout');
        } else {
            return redirect('ipay/checkout');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        //
    }
}
