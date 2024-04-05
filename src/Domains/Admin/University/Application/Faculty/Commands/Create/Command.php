<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Commands\Create;

use Illuminate\Http\UploadedFile;
use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $uuid,
        public readonly string $nameUuid,
        public readonly string $universityUuid,
        public readonly UploadedFile $logo,
        array $translations,
        public readonly bool $isActive,
    )
    {
        $this->setTranslations($translations);
    }
}
