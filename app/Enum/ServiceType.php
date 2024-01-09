<?php

namespace App\Enum;

enum ServiceType: string
{
    case HOTSPOT = 'Hotspot';
    case PPPOE = 'PPPoE';
    case OTHERS = 'Others';
}
