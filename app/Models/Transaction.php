<?php

namespace App\Models;

use App\Enum\PlanType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'username',
        'plan_name',
        'price',
        'recharged_at',
        'expired_at',
        'method',
        'routers',
        'type',
    ];

    protected $casts = [
        'type' => PlanType::class,
        'recharged_at' => 'datetime',
        'expired_at' => 'datetime',
    ];
}
