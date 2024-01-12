<?php

namespace Project\Infrastructure\Services\Authentication\Contracts;

use Project\Shared\Contracts\ArrayableInterface;

interface AuthenticatableInterface extends ArrayableInterface
{
    public function getUuid(): string;

    public function getClaims(): array;
}
