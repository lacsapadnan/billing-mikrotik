<?php

namespace App\Enum;

enum UserType: string
{
    case ADMIN = 'Admin';
    case SALES = 'Sales';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Full Administrator',
            self::SALES => 'Sales',
        };
    }
}
