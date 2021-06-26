<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paypal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'reference',
        'paypal_order_id',
        'token',
        'payload',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
