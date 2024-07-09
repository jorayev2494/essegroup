<?php

namespace Project\Domains\Admin\Document\Domain\Document;

use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Title;
use Project\Shared\Domain\Translation\Translate;

class DocumentTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'title' => Title::class,
    ];

    public static function execute(?Document $item, ?string $locale = null): ?Document
    {
        return parent::translate($item, $locale);
    }
}
