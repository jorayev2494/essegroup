<?php

declare(strict_types=1);

namespace Project\Infrastructure\Generators;

use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;

final class TokenGenerator implements TokenGeneratorInterface
{
    public function generate(): string
    {
        return md5((string) microtime(true));
    }
}
