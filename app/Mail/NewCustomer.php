<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $customer, $random)
    {
        $this->customer = $customer;
        $this->password = $random;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_customer')->subject('Successful Registration');
    }
}
