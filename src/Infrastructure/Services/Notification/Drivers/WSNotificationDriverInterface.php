<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Notification\Drivers;

interface WSNotificationDriverInterface extends BaseNotificationDriver
{
    public function getWSChannel(): string;

    public function getWSData(): array;
}