<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Commands\Update;

use Project\Shared\Application\Command\DTOs\CommandTranslateValue;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Command implements CommandInterface
{
    /**
     * @var array<string, CommandTranslateValue> $translations
     */
    public array $translations;

    public function __construct(
        public readonly string $uuid,
        public readonly string $companyUuid,
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

    private function setTranslations(array $trans): void
    {
        $this->translations = [];

        foreach ($trans as $locale => $translates) {
            foreach ($translates as $field => $value) {
                $this->translations[$locale][] = new CommandTranslateValue($field, $value);
            }
        }
    }
}
