<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department\Services\Translation\Contracts;

use Project\Shared\Domain\Translation\TranslatableInterface;

interface TranslationColumnServiceInterface
{
    public function addTranslations(TranslatableInterface $translatable, array $translations): void;
}
