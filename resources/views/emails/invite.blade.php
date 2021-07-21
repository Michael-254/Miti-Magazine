@component('mail::message')
# Hi {{$invite->name}}

Congratulations.

{{$customer->name}} has invited you to share their Miti magazines copies

@if($password != '')
<h4>An account has been set-up for you</h4>
Your password is {{$password}}.
@endif

@component('mail::button', ['url' => route('user.subscriptions')])
 Get started
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
