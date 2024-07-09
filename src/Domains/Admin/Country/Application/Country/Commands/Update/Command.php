<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Commands\Update;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $uuid,
        public readonly string $iso,
        public array $translations,
        public readonly bool $isActive
    )
    {
        $this->setTranslations($this->translations);
    }
}
