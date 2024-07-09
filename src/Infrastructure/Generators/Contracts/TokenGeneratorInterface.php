<?php

declare(strict_types=1);

namespace Project\Infrastructure\Generators\Contracts;

interface TokenGeneratorInterface
{
    public function generate(int $length = 32): string;
}
