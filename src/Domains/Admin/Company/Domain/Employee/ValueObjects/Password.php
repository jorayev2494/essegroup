<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Employee\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

class Password extends StringValueObject
{
    public const LENGTH = 8;

    public function hash(): string
    {
        return bcrypt($this->value);
    }
}
