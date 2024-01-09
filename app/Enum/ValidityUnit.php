<?php

namespace App\Enum;

enum ValidityUnit: string
{
    case MINS = 'Mins';
    case HRS = 'Hrs';
    case DAYS = 'Days';
    case MONTHS = 'Months';
}
