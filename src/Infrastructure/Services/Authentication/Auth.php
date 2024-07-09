<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication;

use App\Models\Admin;
use App\Models\Auth\Authenticatable;
use Project\Infrastructure\Services\Authentication\Enums\GuardType;
use App\Models\Student;
use Illuminate\Support\Facades\Auth as FrameworkAuth;

class Auth
{
    public static function model(GuardType $guard = null): ?Authenticatable
    {
        return FrameworkAuth::guard($guard ? $guard->value : GuardType::guard())->user();
    }

    public static function admin(): ?Admin
    {
        return FrameworkAuth::admin();
    }

    public static function client(): ?Student
    {
        return FrameworkAuth::client();
    }

    public static function check(GuardType $guard = null): bool
    {
        return FrameworkAuth::guard($guard ? $guard->value : GuardType::guard())->check();
    }

    public static function guest(GuardType $guard = null): bool
    {
        return FrameworkAuth::guard($guard ? $guard->value : GuardType::guard())->guest();
    }

    public static function id(): ?string
    {
        return FrameworkAuth::guard(GuardType::guard())->id();
    }

    public static function logout(GuardType $guard = null): void
    {
        FrameworkAuth::guard($guard ? $guard->value : GuardType::guard())->logout();
    }
}
