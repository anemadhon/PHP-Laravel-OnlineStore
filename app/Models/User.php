<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone_number',
        'address_one',
        'address_two',
        'provincy',
        'regency',
        'zip_code',
        'country'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
