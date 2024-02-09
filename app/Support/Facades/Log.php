<?php

namespace App\Support\Facades;

use App\Models\Customer;
use App\Models\User;
use App\Repository\LogRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void put(string $description, User|Customer $loggable){
 *
 * @see LogRepository
 */
class Log extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LogRepository::class;
    }
}
