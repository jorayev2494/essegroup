<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

class Password extends StringValueObject
{
    public function hash(): string
    {
        return bcrypt($this->value);
    }
}
