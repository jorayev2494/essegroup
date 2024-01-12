<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\RestorePasswordLink;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    function __construct(
        public string $email,
    )
    {

    }
}
