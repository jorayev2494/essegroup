<?php

namespace Project\Infrastructure\Services\Authentication\Enums;

use Illuminate\Support\Facades\Auth;

enum GuardType : string
{
    case CLIENT = 'client';

    case COMPANY = 'company';

    case ADMIN = 'admin';

    public static function guard(): ?string
    {
        return match (true) {
            Auth::guard(self::CLIENT->value)->check() => self::CLIENT->value,
            Auth::guard(self::COMPANY->value)->check() => self::COMPANY->value,
            Auth::guard(self::ADMIN->value)->check() => self::ADMIN->value,
            default => null
        };
    }
}
