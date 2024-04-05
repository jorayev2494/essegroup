<?php

namespace Project\Domains\Admin\Country\Domain\Country;

use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Value;
use Project\Shared\Domain\Translation\Translate;

class CountryTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'value' => Value::class,
    ];

    public static function execute(?Country $item, ?string $locale = null): ?Country
    {
        return parent::translate($item, $locale);
    }
}
