<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Log extends Model
{
    protected $fillable = [
        'description',
        'loggable_id',
        'loggable_type',
        'type',
        'ip',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo('loggable', 'loggable_type', 'loggable_id');
    }
}
