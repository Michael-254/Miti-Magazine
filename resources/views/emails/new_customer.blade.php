@component('mail::message')
# Hi {{$customer->name}}

We are happy to see you at Miti Magazine.

Registration was successfull
Your password is {{$password}}.


@component('mail::button', ['url' => route('profile.show')])
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
