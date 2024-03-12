<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadUserGroup extends Model
{
    use HasFactory;

    protected $table = 'radusergroup';

    protected $fillable = [
        'username',
        'groupname',
        'priority',
    ];
}
