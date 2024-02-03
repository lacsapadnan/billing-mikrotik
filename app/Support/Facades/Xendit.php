<?php

namespace App\Support\Facades;

use App\Repository\PaymentXenditRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string updateConfig(array $data) update xendit config
 *
 * @see PaymentXenditRepository
 */
class Xendit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PaymentXenditRepository::class;
    }
}
