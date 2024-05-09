<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Update;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $uuid,
        public readonly string $nameUuid,
        public readonly string $aliasUuid,
        public readonly string $universityUuid,
        public readonly string $facultyUuid,
        public readonly string $degreeUuid,
        public readonly string $languageUuid,
        array $translations,
        public readonly string $price,
        public readonly string $priceCurrencyUuid,
        public readonly bool $isFilled,
        public readonly bool $isActive,
    )
    {
        $this->setTranslations($translations);
    }
}
