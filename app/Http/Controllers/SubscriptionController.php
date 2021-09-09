<?php

namespace App\Http\Controllers;

use App\Models\Amount;
use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\Magazine;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $currency = SubscriptionPlan::findOrFail($plan_id);
        $amount = Amount::whereSubscriptionPlanId($plan_id)->value($plan_type);
        $recentmagazines = Magazine::whereYear('created_at', '=', Carbon::now()->format('Y'))->latest()->limit(4)->get();
        return view('selected-plan', compact('amount', 'currency', 'countries', 'plan_type', 'recentmagazines'));
    }

    public function checkout()
    {
        $ip = request()->ip();
        $data = \Location::get($ip);
        $Mycountry = $data->countryName ?? '';
        $currency = null;
        switch ($Mycountry) {
            case 'Kenya':
                $currency = 'KSH';
                $rate = 1; 
                break;
            case 'Uganda':
                $currency = 'UGX';
                $rate = ExchangeRate::where('currency', '=', 'KSH')->value('UGX');
                break;
            case 'Tanzania':
                $currency = 'TSH';
                $rate = ExchangeRate::where('currency', '=', 'KSH')->value('TSH');
                break;
            default:
                $currency = '$';
                $rate = ExchangeRate::where('currency', '=', 'KSH')->value('KSHS_USD');
                break;
        }
        $countries = Country::all();
        return view('checkout', compact('countries', 'currency', 'rate'));
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
        Session::put('plan_id', $request->plan_id);
        Session::put('plan_type', $request->plan_type);
        return redirect('subscribe/plan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
