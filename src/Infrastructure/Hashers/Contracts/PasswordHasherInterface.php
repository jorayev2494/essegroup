<?php

namespace Project\Infrastructure\Hashers\Contracts;

use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;

interface PasswordHasherInterface
{
    public function hash(string $value): string;

    public function check(string $password, PasswordValueObject $hashedPassword): bool;
}
