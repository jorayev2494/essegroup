<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Commands\Update;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public string $uuid,
        public string $textColor,
        public string $backgroundColor,
        array $translations,
        public bool $isRequiredNote,
        public bool $isFirst
    ) {
        $this->setTranslations($translations);
    }
}
