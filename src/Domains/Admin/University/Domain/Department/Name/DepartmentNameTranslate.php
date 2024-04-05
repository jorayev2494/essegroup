<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department\Name;

use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Value;
use Project\Shared\Domain\Translation\Translate;

class DepartmentNameTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'value' => Value::class,
    ];

    public static function execute(?DepartmentName $item, ?string $locale = null): ?DepartmentName
    {
        return parent::translate($item, $locale);
    }
}
