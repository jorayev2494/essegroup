<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

readonly abstract class FloatValueObject
{
    public ?float $value;

    public function __construct(?float $value)
    {
        $this->value = $value;
    }

    public static function fromValue(float $value = null): static
    {
        return new static($value);
    }

    public function isEquals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->value !== $other->value;
    }

    public function isBiggerThan(self $other): bool
    {
        return $this->value > $other->value;
    }
}
