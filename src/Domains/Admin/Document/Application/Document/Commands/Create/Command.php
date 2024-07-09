<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Application\Document\Commands\Create;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $uuid,
        public readonly string $type,
        public readonly UploadedFile $file,
        array $translations,
        public readonly bool $isActive
    ) {
        $this->setTranslations($translations);
    }
}
