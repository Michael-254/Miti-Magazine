<?php

namespace App\Http\Livewire;

use App\Models\ExchangeRate as ModelsExchangeRate;
use Livewire\Component;

class ExchangeRate extends Component
{
    public $amend = null;
    public $UGX,$TSH,$KSHS_USD;

    public function change($id)
    {
        $this->amend = $id;
        $selected = ModelsExchangeRate::findOrFail($id);
        $this->UGX = $selected->UGX;
        $this->TSH = $selected->TSH;
        $this->KSHS_USD = $selected->KSHS_USD;
    }

    public function updaterate()
    {

        $rate = ModelsExchangeRate::findOrFail($this->amend);
        $data = $this->validate([
            'UGX' => 'required',
            'TSH' => 'required',
            'KSHS_USD' => 'required',
        ]);

        $rate->update([
            'UGX' => $this->UGX,
            'TSH' => $this->TSH,
            'KSHS_USD' => $this->KSHS_USD,
        ]);

        session()->flash('message', 'Exchange rate updated Successfully');
        $this->reset();
    }

    public function cancel()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.exchange-rate',[
            'rates' => ModelsExchangeRate::all(),
        ]);
    }
}
