<?php

namespace App\Enum;

enum RechargeGateway: string
{
    case RECHARGE = 'Recharge';
    case VOUCHER = 'Voucher';
    case USER = 'User';
    case XENDIT = 'Xendit';
}
