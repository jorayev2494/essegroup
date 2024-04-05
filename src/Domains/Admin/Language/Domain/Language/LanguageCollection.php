<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Domain\Language;

use Project\Shared\Domain\Collection;

class LanguageCollection extends Collection
{

    protected function type(): string
    {
        return Language::class;
    }

    protected function translatorClass(): string
    {
        return LanguageTranslate::class;
    }
}
