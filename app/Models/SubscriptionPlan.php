<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['location','quantity'];

    public function amounts(){
        return $this->hasOne(Amount::class,'subscription_plan_id');
    }

    public function currency():string
    {
        return [
            'Kenya' => 'KSh',
            'Uganda' => 'UGX',
            'Tanzania' => 'TSh',
        ][$this->location] ?? '€';
    }
}
