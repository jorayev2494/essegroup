<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums;

enum Gender: string
{
    case MALE = 'male';

    case FEMALE = 'female';

    public function isEquals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->value !== $other->value;
    }
}
