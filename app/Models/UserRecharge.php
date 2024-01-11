<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'plan_id',
        'username',
        'namebp',
        'recharged_on',
        'recharged_time',
        'expiration',
        'time',
        'status',
        'method',
        'routers',
        'type',
    ];

    public function getIsActiveAttribute(): bool {
        return $this->status === 'on';
    }
}
