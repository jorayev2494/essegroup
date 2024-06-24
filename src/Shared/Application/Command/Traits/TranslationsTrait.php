<?php

namespace Project\Shared\Application\Command\Traits;

use Project\Shared\Application\Command\DTOs\CommandTranslateValue;

trait TranslationsTrait
{
    private readonly array $locales;

    /**
     * @var array<string, CommandTranslateValue> $translations
     */
    public array $translations;

    private function setTranslations(array $trans): void
    {
        $this->translations = [];
        $this->locales = config('app.available_client_translation_locales');

        foreach ($trans as $locale => $translates) {
            if (! $this->isAvailableLocal($locale)) {
                continue;
            }
            foreach ($translates as $field => $value) {
                $this->translations[$locale][] = new CommandTranslateValue($field, $value ?? '');
            }
        }
    }

    private function isAvailableLocal(string $locale): bool
    {
        return in_array($locale, $this->locales);
    }
}
