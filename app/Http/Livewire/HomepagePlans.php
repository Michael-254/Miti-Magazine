<?php

namespace App\Http\Livewire;

use App\Models\location;
use App\Models\SubscriptionPlan;
use Livewire\Component;

class HomepagePlans extends Component
{
    public $copies = 1;
    public $ip = 'Tanzania';
    public $location;

    public function copySelected($value)
    {
        $this->copies = $value;
    }

    public function mount()
    {
        switch ($this->ip) {
            case 'Kenya':
                return $this->location = 'Kenya';
            case 'Uganda':
                return $this->location = 'Uganda';
            case 'Tanzania':
                return $this->location = 'Tanzania';
            default:
                return $this->location = 'Rest of World';
        }
    }

    public function render()
    {
        $plans = SubscriptionPlan::where([['location', $this->location], ['quantity', $this->copies]])->first();
        return view('livewire.homepage-plans', [
            'plans' => $plans
        ]);
    }
}
