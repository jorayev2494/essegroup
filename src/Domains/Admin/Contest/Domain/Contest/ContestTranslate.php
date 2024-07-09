<?php

namespace Project\Domains\Admin\Contest\Domain\Contest;

use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Description;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Title;
use Project\Shared\Domain\Translation\Translate;

class ContestTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'title' => Title::class,
        'description' => Description::class,
    ];

    public static function execute(?Contest $item, ?string $locale = null): ?Contest
    {
        return parent::translate($item, $locale);
    }
}
