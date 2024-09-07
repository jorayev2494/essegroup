<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Notification\ValueObjects;

class Payload
{
    public array $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public static function fromValue(array $value): static
    {
        return new static($value);
    }
}
