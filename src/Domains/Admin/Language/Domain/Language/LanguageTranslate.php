<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Domain\Language;

use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Value;
use Project\Shared\Domain\Translation\Translate;

class LanguageTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'value' => Value::class,
    ];

    public static function execute(?Language $item, ?string $locale = null): ?Language
    {
        return parent::translate($item, $locale);
    }
}
