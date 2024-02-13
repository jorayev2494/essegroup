<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University;

use Project\Domains\Admin\University\Domain\University\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Label;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Name;
use Project\Shared\Domain\Translation\Translate;

class UniversityTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'name' => Name::class,
        'label' => Label::class,
        'description' => Description::class,
    ];

    public static function execute(?University $item, ?string $locale = null): ?University
    {
        return parent::translate($item, $locale);
    }
}
