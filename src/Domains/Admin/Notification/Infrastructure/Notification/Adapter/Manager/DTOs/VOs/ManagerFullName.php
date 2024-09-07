<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\VOs;

readonly class ManagerFullName
{
    public ?string $fullName;

    private function __construct(
        public string $firstName,
        public string $lastName
    ) {
        $this->fullName = ! empty(
            $fullName = sprintf('%s %s', $this->firstName, $this->lastName)
        ) ? $fullName : null;
    }

    public static function fromValues(string $firstName, string $lastName): self
    {
        return new self($firstName, $lastName);
    }
}