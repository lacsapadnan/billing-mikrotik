<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nas extends Model
{
    use HasFactory;

    protected $table = 'nas';

    protected $fillable = [
        'nasname',
        'shortname',
        'type',
        'ports',
        'secret',
        'server',
        'community',
        'description',
        'routers',
    ];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }
}
