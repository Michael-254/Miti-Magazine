<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
        'reference',
        'type',
    ];

    public function subPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function selectedIssue()
    {
        return $this->hasMany(SelectedIssue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('reference', 'like', $term)
                ->orWhere('status', 'like', $term)
                ->orWhere('type', 'like', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('phone_no', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('company', 'like', $term)
                        ->orWhereHas('myCountry', function ($query) use ($term) {
                            $query->where('country', 'like', $term);
                        });
                })
                ->orWhereHas('selectedIssue', function ($query) use ($term) {
                    $query->where('issue_no', 'like', $term);
                });
        });
    }
}
