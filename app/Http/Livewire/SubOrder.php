<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\SelectedIssue;
use Livewire\Component;
use Livewire\WithPagination;

class SubOrder extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $issueNo, $status, $order,$shipping;

    public function Order($id)
    {
        $this->order = Order::findOrFail($id);
        $this->shipping = $this->order->user->shippingInfo;
    }

    public function update()
    {
        $this->validate([
            'issueNo' =>'required',
            'status' =>'required',
        ]);

        $updateIssue = SelectedIssue::findOrFail($this->issueNo);
        $updateIssue->update(['status' => $this->status]);
        session()->flash('message', 'Order Updated');
        $this->reset();
        //Email User
    }

    public function render()
    {
        $orders = Order::with('user', 'subPlan', 'selectedIssue')
            ->where([['status', '!=', 'unverified'], ['type', '=', 'combined']])
            ->latest()
            ->search(trim($this->search))
            ->paginate(10);
        return view('livewire.sub-order', [
            'orders' => $orders
        ]);
    }
}
