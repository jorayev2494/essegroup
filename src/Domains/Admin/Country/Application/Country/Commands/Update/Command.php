<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $companyUuid,
        public string $value,
        public string $iso,
        public bool $isActive
    )
    {

    }
}
