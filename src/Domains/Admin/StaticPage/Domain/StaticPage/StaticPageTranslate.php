<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Content;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Title;
use Project\Shared\Domain\Translation\Translate;

class StaticPageTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'title' => Title::class,
        'content' => Content::class,
    ];

    public static function execute(?StaticPage $item, ?string $locale = null): ?StaticPage
    {
        return parent::translate($item, $locale);
    }
}
