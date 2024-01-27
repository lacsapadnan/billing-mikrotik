<?php

namespace App\Models;

use App\Enum\PlanType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRecharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'plan_id',
        'router_id',
        'username',
        'namebp',
        'recharged_at',
        'expired_at',
        'status',
        'method',
        'type',
    ];

    protected $casts = [
        'type' => PlanType::class,
        'recharged_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function router(): BelongsTo
    {
        return $this->belongsTo(Router::class);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'on';
    }
}
