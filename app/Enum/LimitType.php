<?php

namespace App\Enum;

enum LimitType: string
{
    case TIME_LIMIT = 'Time_Limit';
    case DATA_LIMIT = 'Data_Limit';
    case BOTH_LIMIT = 'Both_Limit';
}
