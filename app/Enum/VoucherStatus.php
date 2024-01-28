<?php

namespace App\Enum;

enum VoucherStatus: int
{
    case UNUSED = 0;
    case USED = 1;
}
