<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\RestorePassword;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $token,
        public string $password,
    )
    {

    }
}
