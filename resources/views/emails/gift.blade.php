@component('mail::message')
# Hi {{$customer->name}}

Congratulations.

Miti Magazine Team has gifted you a Miti Magazine Subscription

@if($password != '')
<h4>An account has been set-up for you</h4>
Your password is {{$password}}.
@endif

@component('mail::button', ['url' => route('user.subscriptions')])
 Unwrap Gift
@endcomponent

Have questions? Please, Email <span class="text-success">miti-magazine@betterglobeforestry.com</span>

<small class="text-sm">
Thanks,<br>
Enjoy!<br>
Claudiah Caroline Deprins<br>
Communications Manager<br>
Better Globe Forestry LTD. 
</small>

@endcomponent
