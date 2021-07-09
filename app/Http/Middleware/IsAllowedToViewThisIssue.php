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
        $userId = auth()->user()->id;
        $selectedIssues = SelectedIssue::whereUserId($userId)->latest()->first();
        $subscription = Subscription::findOrFail($selectedIssues->subscription_id);
        $magazine = Magazine::whereSlug($request->slug)->whereIn('id', $selectedIssues->issues)->get();
        //$isSubscriptionActive = Carbon::parse($subscription->end_date)->isFuture();
        $isInvitedMember = Team::whereIn('issues', $selectedIssues->issues)->get();

        // Check if subscription is active and if the issue is among the selected
        if($isInvitedMember->count() > 0 || $magazine->count() > 0) {
            return $next($request);
        }
        else {
            return redirect()->route('choose.plan');
        }
    }
}
