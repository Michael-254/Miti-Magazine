@component('mail::message')
# Hi {{$customer->name}}

Congratulations.

Miti Magazine Team has gifted you a Miti Magazine Subscription

@if($password != '')
An account has been set-up for you
Your password is <h4>{{$password}}</h4>
@endif

@component('mail::button', ['url' => route('user.subscriptions')])
 Unwrap Gift
@endcomponent

If you have questions, Please reply to this email.

<small class="text-sm">
Thanks,<br>
Enjoy!<br>
Miti Magazine Team<br>
Better Globe Forestry LTD. 
</small>

@endcomponent
