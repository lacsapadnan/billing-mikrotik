<?php

namespace App\Repository;

use App\Support\Facades\Config;
use Exception;

class PaymentXenditRepository
{
    public function __construct()
    {

    }

    public function updateConfig(array $data)
    {
        foreach ($data as $key => $value) {
            if (! (strpos($key, 'xendit_') !== false)) {
                throw new Exception('invalid config key');
            }
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            Config::set($key, $value);
        }
    }
}
