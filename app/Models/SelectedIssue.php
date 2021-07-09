<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'issues',
        'subscription_id'
    ];

    protected $casts = [
        'issues' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
