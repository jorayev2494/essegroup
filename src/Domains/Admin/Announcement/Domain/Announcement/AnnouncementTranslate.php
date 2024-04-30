<?php

namespace Project\Domains\Admin\Announcement\Domain\Announcement;

use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Title;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Content;
use Project\Shared\Domain\Translation\Translate;

class AnnouncementTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'title' => Title::class,
        'content' => Content::class,
    ];

    public static function execute(?Announcement $item, ?string $locale = null): ?Announcement
    {
        return parent::translate($item, $locale);
    }
}
