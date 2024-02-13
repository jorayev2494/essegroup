<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty;

use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Name;
use Project\Shared\Domain\Translation\Translate;

class FacultyTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'name' => Name::class,
        'description' => Description::class,
    ];

    public static function execute(?Faculty $item, ?string $locale = null): ?Faculty
    {
        return parent::translate($item, $locale);
    }
}
