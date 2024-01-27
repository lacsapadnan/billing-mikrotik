<?php

namespace App\Exceptions;

use Exception;

class PackageRechargeException extends AppException
{
    public function __construct(string $message = '', int $code = 0, Exception $previous = null)
    {
        parent::__construct('Recharge Fail: '.$message, $code, $previous);
    }
}
