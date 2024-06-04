<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Application\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $aliasUuid,
        public readonly string $languageUuid,
        public readonly string $degreeUuid,
        public readonly string $countryUuid,
        public readonly string $universityUuid,
        public readonly array $departmentUuids,
        public readonly string $statusValueUuid,
        public readonly array $statusNotes
    ) { }
}
