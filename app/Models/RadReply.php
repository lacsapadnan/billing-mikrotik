<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadReply extends Model
{
    use HasFactory;

    protected $table = 'radreply';

    protected $fillable = [
        'username',
        'attribute',
        'op',
        'value',
    ];
}
