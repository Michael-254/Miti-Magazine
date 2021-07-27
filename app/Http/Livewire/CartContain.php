<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartContain extends Component
{
    protected $listeners = ['NewAdded' => 'render','Removed' => 'render'];

    public function render()
    {
        return view('livewire.cart-contain');
    }
}
