<?php

namespace Project\Domains\Admin\Manager\Application\Permission\Commands\Create;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;
    public function __construct(
        public readonly string $resource,
        public readonly string $action,
        array $translations,
        public readonly bool $isActive
    )
    {
        $this->setTranslations($translations);
    }
}