<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','gifted_user_id','subscription_id'];

    public function members()
    {
        return $this->belongsTo(User::class,'gifted_user_id');
    }

    public function subscriptionSize()
    {
        return $this->belongsTo(Subscription::class,'subscription_id');
    }
}
