<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Application\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $studentUuid,
        public string $aliasUuid,
        public string $languageUuid,
        public string $degreeUuid,
        public string $countryUuid,
        public string $universityUuid,
        public array $departmentUuids
    ) { }
}
