<?php

namespace App\Http\Livewire;

use App\Models\SubscriptionPlan;
use Livewire\Component;
use Livewire\WithPagination;

class ManagePlans extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $location, $quantity;
    public $printed, $digital, $combined;


    public function save()
    {

        $data = $this->validate([
            'location' => 'required',
            'quantity' => 'required',
            'printed' => 'required',
            'digital' => 'required',
            'combined' => 'required',
        ]);

        $plan = SubscriptionPlan::create([
            'location' => $this->location,
            'quantity' => $this->quantity,
        ]);

        $plan->amounts()->create([
            'printed' =>  $this->printed,
            'digital' =>  $this->digital,
            'combined' => $this->combined,
        ]);

        session()->flash('message', 'Plan saved Successfully');
        $this->reset();
    }

    public function destroy($id)
    {
        SubscriptionPlan::findOrFail($id)->delete();
        session()->flash('message', 'Plan deleted Successfully');
    }

    public function render()
    {
        return view('livewire.manage-plans', [
            'plans' => SubscriptionPlan::orderBy('id', 'asc')->paginate(8),
        ]);
    }
}
