<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department;

use Project\Domains\Admin\University\Domain\Department\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Name;
use Project\Shared\Domain\Translation\Translate;

class DepartmentTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'name' => Name::class,
        'description' => Description::class,
    ];

    public static function execute(?Department $item, ?string $locale = null): ?Department
    {
        return parent::translate($item, $locale);
    }
}
