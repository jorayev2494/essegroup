<?php

namespace Project\Shared\Domain\Contracts;

use Project\Shared\Domain\ValueObject\IdValueObject;

interface EntityId
{
    public function getId(): IdValueObject;
}
