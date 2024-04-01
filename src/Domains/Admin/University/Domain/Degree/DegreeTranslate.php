<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Degree;

use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Value;
use Project\Shared\Domain\Translation\Translate;

class DegreeTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'value' => Value::class,
    ];

    public static function execute(?Degree $item, ?string $locale = null): ?Degree
    {
        return parent::translate($item, $locale);
    }
}
