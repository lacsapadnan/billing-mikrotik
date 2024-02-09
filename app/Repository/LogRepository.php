<?php

namespace App\Repository;

use App\Models\Customer;
use App\Models\Log;
use App\Models\User;

class LogRepository
{
    public function put(string $description, User|Customer $loggable)
    {
        Log::create([
            'description' => $description,
            'loggable_id' => $loggable->id,
            'loggable_type' => $loggable::class,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => now(),
        ]);
    }
}
