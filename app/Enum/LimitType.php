<?php

namespace App\Enum;

enum LimitType: string
{
    case TIME_LIMIT = 'Time_Limit';
    case DATA_LIMIT = 'Data_Limit';
    case BOTH_LIMIT = 'Both_Limit';

    public function label()
    {
        return match ($this) {
            self::TIME_LIMIT => 'Time Limit',
            self::DATA_LIMIT => 'Data Limit',
            self::BOTH_LIMIT => 'Both Limit',
        };
    }
}
