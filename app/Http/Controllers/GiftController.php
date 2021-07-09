<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SelectedIssue;
use App\Models\SubscriptionPlan;
use App\Models\Magazine;
use App\Models\Gift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GiftController extends Controller
{
    public function gifts()
    {
        $members = Gift::with('members', 'subscriptionSize')->where('user_id', auth()->id())->latest()->paginate(8);
        $subscriptions = SubscriptionPlan::all();
        $issues = Magazine::all();
        return view('admin.gift', compact('members', 'subscriptions', 'issues'));
    }

    public function postGift(Request $request)
    {
        $request->validate([
            'issue' => 'required',
            'type' => 'required',
            'plan' => 'required',
            'email' => 'required',
            'name' => 'required',
        ]);
       
        $findMember = User::whereEmail($request->email)->first();
        if ($findMember) {
            $customer = $findMember;
        } else {
            $random = Str::random(8);
            $customer = User::Create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($random),
            ]);

            //send email
        }
        
        $quantity = SubscriptionPlan::findOrFail($request->plan)->quantity;
        $referenceId = "GIFTED".auth()->id();
        $subscription = Subscription::create([
            'user_id' => $customer->id, 
            'subscription_plan_id' => $request->plan, 
            'reference' => $referenceId,
            'type' => $request->type,
            'quantity' => $quantity
        ]);

        Gift::create([
            'user_id' => auth()->id(),
            'gifted_user_id' => $customer->id,
            'subscription_id' => $subscription->id
        ]);

        $issues = [
            $request->issue, 
            ($request->issue + 1), 
            ($request->issue + 2), 
            ($request->issue + 3)
        ];
        SelectedIssue::create([
            'user_id' => $customer->id,
            'subscription_id' => $subscription->id,
            'issues' => $issues
        ]);
        
        return redirect()->back()->with('message', 'Member gifted successfully!');
    }

    public function destroyGift(Gift $gift)
    {
        $gift->delete();
        return redirect('admin/gifts')->with('message', 'member removed');
    }
}
