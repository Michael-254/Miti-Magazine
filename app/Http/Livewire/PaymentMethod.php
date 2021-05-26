<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PaymentMethod extends Component
{
    public $method = false;

    public function toggle(){
        $this->method = true;
    }

    public function render()
    {
        return view('livewire.payment-method');
    }
}
