<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Application\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $aliasUuid,
        public string $languageUuid,
        public string $degreeUuid,
        public string $countryUuid,
        public string $universityUuid,
        public array $departmentUuids,
        public string $statusValueUuid,
        public array $statusNotes
    ) { }
}
