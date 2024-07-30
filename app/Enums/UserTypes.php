<?php

namespace App\Enums;

enum UserTypes: string
{
    case STAFF = 'staff';
    case CUSTOMER = 'customer';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
