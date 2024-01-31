<?php

namespace App\Enum;

enum VoucherStatus: string
{
    case UNUSED = '0';
    case USED = '1';

    public function label()
    {
        return match ($this) {
            self::UNUSED => 'Not Use',
            self::USED => 'Used',
        };
    }
}
