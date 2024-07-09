<?php

namespace Project\Infrastructure\Services\Authentication\Contracts;

use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;

interface AuthenticatableInterface extends EntityUuid, ArrayableInterface
{
    public function getClaims(): array;

    public function getPassword(): PasswordValueObject;

    // public function setPassword(PasswordValueObject $password): static;
}
