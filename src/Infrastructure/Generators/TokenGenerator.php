<?php

declare(strict_types=1);

namespace Project\Infrastructure\Generators;

use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;

final class TokenGenerator implements TokenGeneratorInterface
{
    public function generate(int $length = 32): string
    {
        $token = strrev(md5((string) microtime(true)));

        if ($length < 32) {
            $token = substr($token, 0, $length);
        }

        return $token;
    }
}
