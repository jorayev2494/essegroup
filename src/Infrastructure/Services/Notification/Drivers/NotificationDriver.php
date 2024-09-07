<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Notification\Drivers;

use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Domains\Admin\Notification\Infrastructure\Notification\NotificationHandlerFactory;
use Project\Infrastructure\Services\Notification\Contracts\NotificationRecipientInterface;

readonly class NotificationDriver implements WSNotificationDriverInterface
{
    private const CHANNEL = 'notification';

    public function __construct(
        private NotificationRecipientInterface $recipient,
        private Notification $notification
    ) { }

    public function getWSChannel(): string
    {
        return sprintf('%s#%s', self::CHANNEL, $this->recipient->getUuid()->value);
    }

    public function getWSData(): array
    {
        return [
            'uuid' => $this->notification->getUuid()->value,
            'type' => $this->notification->getType()->value,
            'payload' => NotificationHandlerFactory::make($this->notification)->toNotification(),
            'created_at' => $this->notification->getCreatedAt()->getTimestamp(),
        ];
    }
}