<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

class PassportNumber extends StringValueObject
{
    public const REGEX_PATTERN = '/^[A-Z]{1}[0-9]+$/';
}
