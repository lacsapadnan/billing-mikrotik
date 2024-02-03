<?php

namespace App\Support\Facades;

use App\Repository\AppConfigRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string get(string $key) get current app config value
 * @method static Collection all() get all config
 * @method static void set(string $key, string $value) update current app config value
 *
 * @see AppConfigRepository
 */
class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AppConfigRepository::class;
    }
}
