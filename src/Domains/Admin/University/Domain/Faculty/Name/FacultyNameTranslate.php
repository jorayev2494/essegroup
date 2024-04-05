<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty\Name;

use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Value;
use Project\Shared\Domain\Translation\Translate;

class FacultyNameTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'value' => Value::class,
    ];

    public static function execute(?FacultyName $item, ?string $locale = null): ?FacultyName
    {
        return parent::translate($item, $locale);
    }
}
