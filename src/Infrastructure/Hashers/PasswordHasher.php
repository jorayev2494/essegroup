<?php

namespace Project\Infrastructure\Hashers;

use Illuminate\Support\Facades\Hash;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;
use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;

class PasswordHasher implements PasswordHasherInterface
{
    public function hash(string $value): string
    {
        return bcrypt($value);
    }

    public function check(string $password, PasswordValueObject $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword->value);
    }
}
