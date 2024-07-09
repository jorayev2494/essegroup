<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\City;

use Project\Domains\Admin\Country\Domain\City\ValueObjects\Value;
use Project\Shared\Domain\Translation\Translate;

class CityTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'value' => Value::class,
    ];

    public static function execute(?City $item, ?string $locale = null): ?City
    {
        return parent::translate($item, $locale);
    }
}
