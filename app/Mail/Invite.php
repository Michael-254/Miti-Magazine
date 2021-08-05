<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invite extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $invite;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,User $findMember, $random)
    {
        $this->customer = $user;
        $this->password = $random;
        $this->invite = $findMember;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invite')
        ->subject('Invitation to online Miti Magazine')
        ->replyTo('miti-magazine@betterglobeforestry.com');
    }
}
