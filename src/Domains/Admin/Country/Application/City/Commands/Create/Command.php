<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\City\Commands\Create;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public string $uuid,
        public string $countryUuid,
        array $translations,
        public bool $isActive,
    )
    {
        $this->setTranslations($translations);
    }
}
