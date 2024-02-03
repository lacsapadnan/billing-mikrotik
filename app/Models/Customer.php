<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $rememberTokenName = false;

    protected $fillable = [
        'username',
        'password',
        'pppoe_password',
        'fullname',
        'address',
        'phonenumber',
        'email',
        'balance',
        'service_type',
        'auto_renewal',
        'last_login',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    public function recharges(): HasMany
    {
        return $this->hasMany(UserRecharge::class);
    }
}
