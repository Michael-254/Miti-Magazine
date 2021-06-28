<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\Paypal;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPaypal extends Component
{
    Use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    { 
        return view('livewire.admin-paypal',[
            'payments' => Paypal::with('user')
            ->where('status','verified')
            ->search(trim($this->search))
            ->paginate(10),
        ]);
    }
}
