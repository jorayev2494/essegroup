<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $studentUuid,
        public string $languageUuid,
        public string $degreeUuid,
        public string $universityUuid,
        public array $departmentUuids,
        public bool $isAgreedToShareData,
        public string $creatorRole,
        public ?string $aliasUuid,
        public ?string $countryUuid
    ) { }
}
