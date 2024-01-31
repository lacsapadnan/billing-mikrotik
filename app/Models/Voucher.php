<?php

namespace App\Models;

use App\Enum\PlanType;
use App\Enum\VoucherStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'router_id',
        'user',
        'type',
        'code',
        'status',
    ];

    protected $casts = [
        'type' => PlanType::class,
        'status' => VoucherStatus::class,
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function router(): BelongsTo
    {
        return $this->belongsTo(Router::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
