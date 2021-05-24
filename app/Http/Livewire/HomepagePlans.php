<?php

namespace App\Http\Livewire;

use App\Models\Location;
use App\Models\SubscriptionPlan;
use Livewire\Component;

class HomepagePlans extends Component
{

    public function render()
    {
        $plans = SubscriptionPlan::where('location', 'Kenya')->get();
        return view('livewire.homepage-plans',[
            'plans' => $plans
        ]);
    }
}
