<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\SubscriptionPlan;
use Livewire\Component;

class HomepagePlans extends Component
{
    public $copies = 1;
    public $location = 'Kenya';

    public function copySelected($value)
    {
        $this->copies = $value;
    }

    public function render()
    {
        $plans = SubscriptionPlan::where([['location', $this->location],['quantity', $this->copies]])->first();
        return view('livewire.homepage-plans', [
            'plans' => $plans
        ]);
    }
}
