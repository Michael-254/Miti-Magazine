<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Session;

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
            'payment_method' => 'required'
        ]);

        $customer = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'country' => $request->country,
            'company' => $request->company,
            'password' => bcrypt('123456'),
        ]);
        Session::put('customer_id', $customer->id);

        $address = $customer->shippingInfo()->create([
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'apartment' => $request->apartment,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        if($request->payment_method == 'paypal'){
            return redirect('paypal/checkout');
        }
        else{
            return 'ipay';
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
