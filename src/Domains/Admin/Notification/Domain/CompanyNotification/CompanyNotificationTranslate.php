<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\CompanyNotification;

use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Content;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Title;
use Project\Shared\Domain\Translation\Translate;

class CompanyNotificationTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        'title' => Title::class,
        'content' => Content::class,
    ];

    public static function execute(?CompanyNotification $item, ?string $locale = null): ?CompanyNotification
    {
        return parent::translate($item, $locale);
    }
}
