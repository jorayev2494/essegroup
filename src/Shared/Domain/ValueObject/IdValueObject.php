<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Project\Shared\Contracts\NullableInterface;

class IdValueObject implements NullableInterface, \Stringable
{
    public ?int $value;

    protected function __construct(?int $value)
    {
        $this->assertIsValidId($value);
        $this->value = $value;
    }

    public static function fromValue(?int $value): static
    {
        return new static($value);
    }

    private function assertIsValidId(?int $value): void
    {
        if (! is_null($value) && ! is_int($value) && $value > 0) {
            throw new InvalidArgumentException(sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $value));
        }
    }

    public function isEquals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->value !== $other->value;
    }

    public function isNull(): bool
    {
        return $this->value === null;
    }

    public function isNotNull(): bool
    {
        return $this->value !== null;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
