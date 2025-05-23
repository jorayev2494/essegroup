<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Application\Authentication\Commands\Login;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $password,
        public string $deviceId
    ) { }
}
