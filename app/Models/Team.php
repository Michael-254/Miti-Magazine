<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','team_member_id','subscription_id'];

    public function members()
    {
        return $this->belongsTo(User::class,'team_member_id');
    }

    public function subscriptionSize()
    {
        return $this->belongsTo(Subscription::class,'subscription_id');
    }
}
