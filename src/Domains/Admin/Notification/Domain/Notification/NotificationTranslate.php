<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Notification;

use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Content;
use Project\Shared\Domain\Translation\Translate;

class NotificationTranslate extends Translate
{
    protected const COLUMNS_WITH_TRANSLATE = [
        // 'title' => Title::class,
        'content' => Content::class,
    ];

    public static function execute(?Notification $item, ?string $locale = null): ?Notification
    {
        return parent::translate($item, $locale);
    }
}
