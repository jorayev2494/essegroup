<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Notification\Contracts;

readonly abstract class NotificationData
{
    public const TYPE = 'default';

    public function getType(): string
    {
        return static::TYPE;
    }

    abstract public static function fromArray(array $data): static;

    abstract public function toPayload(): array;

    abstract public function toNotification(): array;
}