<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\Contest\Commands\Create;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $uuid,
        public readonly int $participantsNumber,
        array $translations,
        public readonly array $applicationStatusUuids,
        public readonly array $studentNationalityUuids,
        public readonly string $startTime,
        public readonly bool $isActive,
        public readonly ?string $endTime
    ) {
        $this->setTranslations($translations);
    }
}
