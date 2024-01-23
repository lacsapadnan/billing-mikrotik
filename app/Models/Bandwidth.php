<?php

namespace App\Models;

use App\Enum\RateUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandwidth extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_bw',
        'rate_down',
        'rate_down_unit',
        'rate_up',
        'rate_up_unit',
    ];

    protected $casts = [
        'rate_down_unit' => RateUnit::class,
        'rate_up_unit' => RateUnit::class,
    ];

    protected $appends = ['rate_down_label', 'rate_up_label'];

    public function getRateDownLabelAttribute(): string
    {
        return $this->rate_down.' '.$this->rate_down_unit?->value;
    }

    public function getRateUpLabelAttribute(): string
    {
        return $this->rate_up.' '.$this->rate_up_unit?->value;
    }
}
