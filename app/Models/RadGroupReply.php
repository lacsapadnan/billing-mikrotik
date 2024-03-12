<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RadGroupReply extends Model
{
    use HasFactory;

    protected $table = 'radgroupreply';

    protected $fillable = [
        'groupname',
        'attribute',
        'op',
        'value',
        'plan_id',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
