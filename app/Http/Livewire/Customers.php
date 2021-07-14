<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        $customers = User::with('shippingInfo','myCountry','subscriptions','myTeam','myIssues')->search(trim($this->search))->latest()->paginate(10);
        return view('livewire.customers', [
            'customers' => $customers,
        ]);
    }
}
