<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\CompanyNotification\Commands\Create;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $companyUuid,
        public array $translations,
    ) {
        $this->setTranslations($this->translations);
    }
}