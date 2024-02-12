<?php

namespace App\Models;

use App\Enum\DataUnit;
use App\Enum\LimitType;
use App\Enum\PlanType;
use App\Enum\PlanTypeBp;
use App\Enum\TimeUnit;
use App\Enum\ValidityUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bandwidth_id',
        'price',
        'type',
        'typebp',
        'limit_type',
        'time_limit',
        'time_unit',
        'data_limit',
        'data_unit',
        'validity',
        'validity_unit',
        'shared_users',
        'router_id',
        'is_radius',
        'pool_id',
        'pool_expired_id',
        'enabled',
    ];

    protected $casts = [
        'type' => PlanType::class,
        'typebp' => PlanTypeBp::class,
        'time_unit' => TimeUnit::class,
        'limit_type' => LimitType::class,
        'data_unit' => DataUnit::class,
        'validity_unit' => ValidityUnit::class,
    ];

    protected $appends = ['time_limit_text', 'data_limit_text', 'validity_text'];

    public function bandwidth(): BelongsTo
    {
        return $this->belongsTo(Bandwidth::class);
    }

    public function router(): BelongsTo
    {
        return $this->belongsTo(Router::class);
    }

    public function pool_expired(): BelongsTo
    {
        return $this->belongsTo(Pool::class, 'pool_expired_id');
    }

    public function getTimeLimitTextAttribute(): string
    {
        if ($this->limit_type == LimitType::TIME_LIMIT || $this->limit_type == LimitType::BOTH_LIMIT) {
            return $this->time_limit.' '.$this->time_unit?->value;
        }

        return '';
    }

    public function getDataLimitTextAttribute(): string
    {
        if ($this->limit_type == LimitType::DATA_LIMIT || $this->limit_type == LimitType::BOTH_LIMIT) {
            return $this->data_limit.' '.$this->data_unit?->value;
        }

        return '';
    }

    public function getValidityTextAttribute()
    {
        return $this->validity.' '.$this->validity_unit?->value;
    }

    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class, 'pool_id');
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }
}
