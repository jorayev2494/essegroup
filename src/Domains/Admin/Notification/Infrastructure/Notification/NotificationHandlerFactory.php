<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Notification;

use Project\Domains\Admin\Notification\Domain\Notification\Contracts\NotificationData;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class NotificationHandlerFactory
{
    /**
     * @var array<array-key, NotificationData> $notificationHandlers
     */
    private static array $notificationHandlers;

    public static function make(Notification $notification): NotificationData
    {
        self::$notificationHandlers = resolve('notifications');

        if (! array_key_exists($type = $notification->getType()->value, self::$notificationHandlers)) {
            throw new BadRequestHttpException(sprintf('The %s handler not found', $type));
        }

        return self::$notificationHandlers[$type]::fromArray($notification->getPayload()->value);
    }
}