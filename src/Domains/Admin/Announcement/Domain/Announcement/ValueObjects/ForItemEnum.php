<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects;

enum ForItemEnum : string
{
    case ANYONE = 'anyone';

    case MANAGER = 'manager';

    case COMPANY = 'company';

    case STUDENT = 'student';

    public function isNotEquals(self $other): bool
    {
        return $this->value !== $other->value;
    }
}
