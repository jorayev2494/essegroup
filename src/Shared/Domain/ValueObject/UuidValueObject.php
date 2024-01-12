<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;


class UuidValueObject implements \Stringable
{
    public ?string $value;

    protected function __construct(?string $value)
    {
        $this->assertIsValidUuid($value);
        $this->value = $value;
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public static function fromValue(?string $value): static
    {
        return new static($value);
    }

    private function assertIsValidUuid(?string $value): void
    {
        if (! is_null($value) && ! Uuid::isValid($value)) {
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

    public function __toString(): string
    {
        return $this->value;
    }
}
