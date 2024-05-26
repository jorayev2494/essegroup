<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

class Password extends StringValueObject
{
    public function hash(): string
    {
        return bcrypt($this->value);
    }
}
