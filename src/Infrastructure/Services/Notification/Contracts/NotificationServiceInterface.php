<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Notification\Contracts;

use Project\Domains\Admin\Notification\Domain\Notification\Contracts\NotificationData;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Infrastructure\Services\Notification\Drivers\BaseNotificationDriver;

interface NotificationServiceInterface
{
    public function create(NotificationData $notificationData): Notification;

    public function notify(BaseNotificationDriver $notificationDriver): void;
}