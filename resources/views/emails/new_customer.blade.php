@component('mail::message')
# Hi {{$customer->name}}

We are happy to see you at Miti Magazine.

<h4>Registration was successfull</h4>
Your password is {{$password}}.


@component('mail::button', ['url' => route('profile.show')])
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
