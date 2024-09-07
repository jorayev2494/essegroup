<?php

namespace Project\Domains\Admin\Notification\Domain\Notification\Services\Contracts;

use Project\Domains\Admin\Notification\Domain\Manager\Manager;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;

interface NotificationNotifyServiceInterface
{
    public function markAsViewed(Notification $notification, Manager $manager): void;
}