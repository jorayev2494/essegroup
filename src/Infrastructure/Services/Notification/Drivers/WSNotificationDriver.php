<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Notification\Drivers;

use Project\Infrastructure\Services\Notification\Contracts\NotificationRecipientInterface;

readonly class WSNotificationDriver implements WSNotificationDriverInterface
{
    private const CHANNEL = 'notification';

    public function __construct(
        private NotificationRecipientInterface $recipient,
        private array $data
    ) { }

    public function getWSChannel(): string
    {
        return sprintf('%s#%s', self::CHANNEL, $this->recipient->getUuid()->value);
    }

    public function getWSData(): array
    {
        return $this->data;
    }
}