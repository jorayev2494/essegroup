<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Translation;

use Project\Shared\Application\Command\DTOs\CommandTranslateValue;

class TranslationColumnService implements TranslationColumnServiceInterface
{
    #[\Override]
    public function addTranslations(TranslatableInterface $translatable, array $translations): void
    {
        foreach ($translations as $locale => $translates) {
            /** @var CommandTranslateValue $translate */
            foreach ($translates as $translate) {
                $translatable->addTranslation(
                    $translatable->getTranslationClass()::make($locale, $translate->field, $translate->value)
                );
            }
        }
    }
}
