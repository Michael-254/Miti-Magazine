<?php

namespace App\Http\Livewire;

use App\Models\location;
use App\Models\SubscriptionPlan;
use Livewire\Component;

class HomepagePlans extends Component
{
    public $copies = 1;
    public $Mycountry;
    public $location;

    public function copySelected($value)
    {
        $this->copies = $value;
    }

    public function mount()
    {
        $ip = request()->ip();
        $data = \Location::get($ip);
        $this->Mycountry = $data->countryName;
        switch ($this->Mycountry) {
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
