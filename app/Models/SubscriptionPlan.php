<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    public function amounts(){
        return $this->hasOne(Amount::class,'subscription_plan_id');
    }
}
