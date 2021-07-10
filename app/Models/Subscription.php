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
        'quantity',
        'start_date',
        'end_date',
    ];

    public function SubIssues()
    {
        return $this->hasMany(SelectedIssue::class,'subscription_id');
    }
}
