<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'reference',
        'issues',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('reference', 'like', $term)
                ->orWhere('status', 'like', $term)
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
