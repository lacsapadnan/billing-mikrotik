<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

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
}
