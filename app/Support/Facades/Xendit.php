<?php

namespace App\Support\Facades;

use App\Models\Customer;
use App\Models\PaymentGateway;
use App\Repository\PaymentXenditRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string updateConfig(array $data) update xendit config
 * @method static void validateConfig() validate xendit config
 * @method static void createTransaction(PaymentGateway $trx, Customer $user)
 * @method static boolean getStatus(PaymentGateway $trx, Customer $user)
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
