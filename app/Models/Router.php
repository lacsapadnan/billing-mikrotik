<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Router extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'username',
        'password',
        'description',
        'enabled',
    ];

    protected $appends = [
        'status',
    ];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function getStatusAttribute(): string
    {
        return $this->enabled ? 'Enabled' : 'Disabled';
    }
}
