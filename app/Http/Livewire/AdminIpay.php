<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class AdminIpay extends Component
{
    Use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public function render()
    {
        return view('livewire.admin-ipay',[
            'payments' => Payment::with('user')
            ->where('status','verified')
            ->search(trim($this->search))
            ->latest()
            ->paginate(10),
        ]);
    }
}
