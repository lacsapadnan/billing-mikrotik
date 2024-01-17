<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;

    protected $fillable = [
        'pool_name',
        'range_ip',
        'router_id',
    ];

    public function router()
    {
        return $this->belongsTo(Router::class);
    }
}
