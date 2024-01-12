<?php

namespace Project\Infrastructure\Hashers;

use Illuminate\Support\Facades\Hash;
use Project\Infrastructure\Hashers\Contracts\PasswordHasherInterface;

class PasswordHasher implements PasswordHasherInterface
{
    public function hash(string $value): string
    {
        return bcrypt($value);
    }

    public function check(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
