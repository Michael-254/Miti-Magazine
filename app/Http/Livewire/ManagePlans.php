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
    public $digital, $combined;
    public $amend = null;
    public $digitalE, $combinedE, $locationE, $quantityE;


    public function save()
    {

        $this->amend = '';
        $data = $this->validate([
            'location' => 'required',
            'quantity' => 'required',
            'digital' => 'required',
            'combined' => 'required',
        ]);

        $plan = SubscriptionPlan::create([
            'location' => $this->location,
            'quantity' => $this->quantity,
        ]);

        $plan->amounts()->create([
            'digital' =>  $this->digital,
            'combined' => $this->combined,
        ]);

        session()->flash('message', 'Plan saved Successfully');
        $this->reset();
    }

    public function updatePlan()
    {

        $plan = SubscriptionPlan::findOrFail($this->amend);
        $data = $this->validate([
            'locationE' => 'required',
            'quantityE' => 'required',
            'digitalE' => 'required',
            'combinedE' => 'required',
        ]);

        $plan->update([
            'location' => $this->locationE,
            'quantity' => $this->quantityE,
        ]);

        $plan->amounts()->update([
            'digital' =>  $this->digitalE,
            'combined' => $this->combinedE,
        ]);

        session()->flash('message', 'Plan updated Successfully');
        $this->reset();
    }

    public function change($id)
    {
        $this->amend = $id;
        $selected = SubscriptionPlan::findOrFail($id);
        $this->locationE = $selected->location;
        $this->quantityE = $selected->quantity;
        $this->digitalE = $selected->amounts->digital;
        $this->combinedE = $selected->amounts->combined;
    }

    public function cancel()
    {
        $this->reset();
    }

    public function destroy($id)
    {
        $this->amend = '';
        SubscriptionPlan::findOrFail($id)->delete();
        session()->flash('message', 'Plan deleted Successfully');
    }

    public function render()
    {
        return view('livewire.manage-plans', [
            'plans' => SubscriptionPlan::with('amounts')->orderBy('id', 'asc')->paginate(6),
        ]);
    }
}
