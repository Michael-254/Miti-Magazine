<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
        'reference',
        'type',
        'start_date',
        'end_date',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(Subscription::class,'subscription_plan_id');
    }
}
