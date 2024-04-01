<?php

namespace Project\Shared\Domain\Contracts;

use Project\Shared\Domain\ValueObject\UuidValueObject;

interface EntityUuid
{
    public function getUuid(): UuidValueObject;
}
