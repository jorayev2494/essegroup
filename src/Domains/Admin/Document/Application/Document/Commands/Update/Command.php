<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Application\Document\Commands\Update;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $uuid,
        public readonly string $type,
        array $translations,
        public readonly bool $isActive,
        public readonly ?UploadedFile $file
    ) {
        $this->setTranslations($translations);
    }
}
