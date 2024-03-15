<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Translation;

interface TranslationColumnServiceInterface
{
    public function addTranslations(TranslatableInterface $translatable, array $translations): void;
}
