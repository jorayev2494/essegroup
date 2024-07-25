<?php

namespace Project\Domains\Admin\Manager\Application\Permission\Commands\Update;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;
    public function __construct(
        public readonly int $id,
        array $translations,
        public readonly bool $isActive
    )
    {
        $this->setTranslations($translations);
    }
}