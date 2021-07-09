<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_code',
        'name',
        'email',
        'password',
        'country',
        'phone_no',
        'gender',
        'avatar',
        'company',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFilesDirectory()
    {
        return null;
    }

    public function shippingInfo()
    {
        return $this->hasOne(Shipping::class);
    }

    public function myCountry(){
        return $this->belongsTo(Country::class,'country');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function myTeam()
    {
        return $this->hasMany(Team::class);
    }

    public function myIssues()
    {
        return $this->hasMany(SelectedIssue::class);
    }


    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhere('company', 'like', $term)
                ->orWhere('phone_no', 'like', $term)
                ->orWhereHas('shippingInfo', function ($query) use ($term) {
                    $query->where('address', 'like', $term)
                        ->orWhere('apartment', 'like', $term)
                        ->orWhere('zip_code', 'like', $term)
                        ->orWhere('city', 'like', $term);
                })
                ->orWhereHas('myCountry', function ($query) use ($term) {
                    $query->where('country', 'like', $term);
                });
        });
    }

}
