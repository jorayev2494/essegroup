<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Commands\Create;

use Project\Shared\Application\Command\Traits\TranslationsTrait;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Command implements CommandInterface
{
    use TranslationsTrait;

    public function __construct(
        public readonly string $uuid,
        public readonly string $countryUuid,
        public readonly string $cityUuid,
        public readonly ?UploadedFile $logo,
        public readonly ?UploadedFile $cover,
        public readonly string $youtubeVideoId,
        array $translations,
        public bool $isOnTheCountryList
    )
    {
        $this->setTranslations($translations);
    }
}
