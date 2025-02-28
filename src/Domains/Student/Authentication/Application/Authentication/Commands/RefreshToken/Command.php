<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Application\Authentication\Commands\RefreshToken;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $deviceId,
        public string $refreshToken
    ) { }
}
