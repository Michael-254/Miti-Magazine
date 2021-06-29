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
        'currency',
        'amount',
        'reference',
        'paypal_order_id',
        'token',
        'PayerID',
        'payload',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('reference', 'like', $term)
                ->orWhere('amount', 'like', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('phone_no', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('company', 'like', $term)
                        ->orWhereHas('myCountry', function ($query) use ($term) {
                            $query->where('country', 'like', $term);
                        });
                });
        });
    }
}
