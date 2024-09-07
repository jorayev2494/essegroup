<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Notification\Services;

use Project\Domains\Admin\Notification\Domain\Manager\Manager;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Domains\Admin\Notification\Domain\Notification\Services\Contracts\NotificationNotifyServiceInterface;

readonly class NotificationNotifyService implements NotificationNotifyServiceInterface
{
    public function __construct(

    ) { }

    public function markAsViewed(Notification $notification, Manager $manager): void
    {
        $notification->addViewedManagers($manager);
    }
}