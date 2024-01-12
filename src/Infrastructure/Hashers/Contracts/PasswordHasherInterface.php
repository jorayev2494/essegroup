<?php

namespace Project\Infrastructure\Hashers\Contracts;

interface PasswordHasherInterface
{
    public function hash(string $value): string;

    public function check(string $password, string $hashedPassword): bool;
}
