<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\SelectedIssue;
use App\Models\Magazine;
use App\Models\Team;
use Carbon\Carbon;

class IsAllowedToViewThisIssue
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = auth()->id();
        $subscriptions = Subscription::where([['user_id', '=', $userId], ['status', '=', 'paid']])->get();
        foreach ($subscriptions as $subscription) {
            $selectedIssues = SelectedIssue::whereSubscriptionId($subscription->id)->pluck('issue_no')->toArray();
        }
        $magazine = Magazine::whereSlug($request->route('slug'))->whereIn('issue_no', $selectedIssues)->get();

        $isInvitedSubscription = Team::where('team_member_id', '=', $userId)->pluck('subscription_id');
        foreach ($isInvitedSubscription as $subscription) {
            $invitedSub = Subscription::findOrFail($subscription);
            $invitedIssues = $invitedSub->SubIssues->pluck('issue_no')->toArray();
        }
        $Invitedmagazine = Magazine::whereSlug($request->route('slug'))->whereIn('issue_no', $invitedIssues)->get();

        // Check if subscription is active and if the issue is among the selected
        if ($Invitedmagazine->count() > 0 || $magazine->count() > 0) {
            return $next($request);
        } else {
            return redirect()->route('choose.plan');
        }
    }
}
