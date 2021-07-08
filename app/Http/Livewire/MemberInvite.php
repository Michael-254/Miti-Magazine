<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class MemberInvite extends Component
{
    public $SelectedPlan,$subId;

    public function updatedAuditee($auditee)
    {
      if (!is_null($auditee)) {
        $selected = User::where('id', $auditee)->first();
        $this->site =  $selected->site;
        $this->auditeeN =  $selected->name;
      }
    }

    public function render()
    {
        return view('livewire.member-invite');
    }
}
