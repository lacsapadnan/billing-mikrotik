<?php

namespace App\Enum;

enum PaymentGatewayStatus: int
{
    case UNPAID = 1;
    case PAID = 2;
    case FAILED = 3;
    case CANCELED = 4;
}
