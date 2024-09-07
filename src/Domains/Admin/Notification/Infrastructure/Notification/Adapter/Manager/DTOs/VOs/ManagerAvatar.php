<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\VOs;

readonly class ManagerAvatar
{
    public function __construct(
        public ?array $value
    ) { }

    public static function fromValue(?array $value): self
    {
        return new self($value);
    }
}