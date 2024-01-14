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
}
