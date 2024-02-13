<?php

namespace Project\Shared\Application\Command\Traits;

use Project\Shared\Application\Command\DTOs\CommandTranslateValue;

trait TranslationsTrait
{
    /**
     * @var array<string, CommandTranslateValue> $translations
     */
    public array $translations;

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
