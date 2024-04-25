<?php

namespace Project\Infrastructure\Services\Authentication\Contracts;

use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;

interface AuthenticatableInterface extends EntityUuid, ArrayableInterface
{
    public function getClaims(): array;
}
