@component('mail::message')
# Hi {{$invite->name}}

Congratulations.

{{$customer->name}} has invited you to share their Miti magazines copies

@if($password != '')
An account has been set-up for you
Your password is <h4>{{$password}}<h4>.
@endif

@component('mail::button', ['url' => route('user.subscriptions')])
 Get started
@endcomponent

If you have questions, Please reply to this email.

<small class="text-sm">
Thanks,<br>
Enjoy!<br>
Miti Magazine Team<br>
Better Globe Forestry LTD. 
</small>

@endcomponent
