<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Notification\Contracts;

interface NotificationDriverInterface
{
    public function recipient(NotificationRecipientInterface $recipient): self;

    public function notify(): void;
}