<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Application\Manager\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $email,
        public string $companyUuid
    ) {

    }
}