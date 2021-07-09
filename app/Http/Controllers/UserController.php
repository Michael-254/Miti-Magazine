<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Paypal;
use App\Models\SelectedIssue;
use App\Models\Shipping;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function show()
    {
        $countries = Country::all();
        return view('users.update-profile', compact('countries'));
    }

    public function update(ProfileUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
        Shipping::UpdateOrCreate([
            'user_id' => $user->id,
        ], [
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'apartment' => $request->apartment,
            'city' => $request->city,
            'state' => $request->state,
        ]);
        return redirect('user/profile')->with('message', 'Updated successfully');
    }

    public function passwordChange()
    {
        return view('users.password-change');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors('Current password does not match!');
        }

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
        return redirect('user/profile')->with('message', 'Password updated');
    }

    public function mypayments()
    {
        $ipaypayments = Payment::where([['user_id', '=', auth()->id()], ['status', '=', 'verified']])
            ->select('amount', 'reference', 'updated_at', 'channel')
            ->paginate(8);
        $paypalpayments = Paypal::where([['user_id', '=', auth()->id()], ['status', '=', 'verified']])
            ->select('amount', 'reference', 'updated_at')
            ->paginate(8);
        return view('users.my-payments', compact('ipaypayments', 'paypalpayments'));
    }

    public function invite()
    {
        $members = Team::with('members', 'subscriptionSize')->where('user_id', auth()->id())->latest()->paginate(8);
        $userSubscriptions = Subscription::where([['user_id', auth()->id()],['status','=','paid']])->get();
        return view('users.invite', compact('members','userSubscriptions'));
    }

    public function memberStore(Request $request)
    {
        $request->validate([
            'plan' => 'required',
            'email' => 'required',
            'name' => 'required',
        ]);
        $myPlans = auth()->user()->subscriptions;
        if ($myPlans->contains('id', $request->plan)) {
            $Usersubscription = Subscription::findOrFail($request->plan)->subscription_plan_id;
            $invites = Team::where([['user_id', '=', auth()->id()], ['subscription_id', '=', $request->plan]])->count();
            $quantity = SubscriptionPlan::findOrFail($Usersubscription)->quantity;
            $issues = SelectedIssue::where('subscription_id','=',$request->plan)->first()->issues;

            if ($invites < ($quantity - 1)) {

                $findMember = User::where('email', '=', $request->email)->first();
                if ($findMember) {
                    Team::create(['user_id' => auth()->id(), 'team_member_id' => $findMember->id]);
                } else {
                    $random = Str::random(8);
                    $member = User::Create([
                        'email' => $request->email,
                        'name' => $request->name,
                        'password' => bcrypt($random),
                    ]);

                    Team::create([
                        'user_id' => auth()->id(),
                        'team_member_id' => $member->id,
                        'subscription_id' => $request->plan,
                        'issues' => $issues, 
                    ]);

                    //send email
                    return redirect()->back()->with('message', 'Member invited successfully. A notification has been sent to them');
                }
            } else {
                return redirect()->back()->with('error', 'You have exceeded max no of invites kindly upgrade');
            }
        } else {
            return redirect()->back()->with('error', 'Something went wrong wrong kindly retry again');
        }
    }

    public function memberdestroy(Team $team)
    {
        $team->delete();
        return redirect('user/invites')->with('message', 'member removed');
    }
}
