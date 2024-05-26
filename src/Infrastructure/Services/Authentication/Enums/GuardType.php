<?php

namespace Project\Infrastructure\Services\Authentication\Enums;

use Illuminate\Support\Facades\Auth;

enum GuardType : string
{
    case STUDENT = 'student';

    case COMPANY = 'company';

    case MANAGER = 'admin';

    public static function guard(): ?string
    {
        return match (true) {
            Auth::guard(self::STUDENT->value)->check() => self::STUDENT->value,
            Auth::guard(self::COMPANY->value)->check() => self::COMPANY->value,
            Auth::guard(self::MANAGER->value)->check() => self::MANAGER->value,
            default => null
        };
    }
}
