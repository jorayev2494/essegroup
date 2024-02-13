<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University\Services\Translation;

use Project\Domains\Admin\University\Domain\University\Services\Translation\Contracts\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\University\UniversityTranslation;
use Project\Shared\Application\Command\DTOs\CommandTranslateValue;
use Project\Shared\Domain\Translation\TranslatableInterface;

class TranslationColumnService implements TranslationColumnServiceInterface
{
    #[\Override]
    public function addTranslations(TranslatableInterface $translatable, array $translations): void
    {
        foreach ($translations as $locale => $translates) {
            /** @var CommandTranslateValue $translate */
            foreach ($translates as $translate) {
                $translatable->addTranslation(UniversityTranslation::make($locale, $translate->field, $translate->value));
            }
        }
    }
}
