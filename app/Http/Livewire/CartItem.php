<?php

namespace App\Http\Livewire;

use App\Models\Magazine;
use Livewire\Component;
use Cart;

class CartItem extends Component
{
    public $quantity = 1;

    public $magazine;

    public function mount($magazine)
    {

        $this->magazine = $magazine;
    }

    public function cart($id)
    {
        $magazine = Magazine::findOrFail($id);
        $cart = Cart::add([
            'id' => $magazine->id,
            'name' => $magazine->issue_no,
            'price' => 250,
            'quantity' => $this->quantity,
        ]);

        $this->reset('quantity');
        $this->emit('NewAdded');
        session()->flash('message', 'Successfully added to cart');
    }

    public function remove($id)
    {
        Cart::remove($id);

        $this->emit('Removed');
        session()->flash('message', 'Successfully removed from cart');
    }

    public function render()
    {
        return view('livewire.cart-item');
    }
}
