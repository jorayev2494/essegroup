<?php

namespace Project\Domains\Student\Profile\Domain\Profile\Services\Contracts;

use Project\Domains\Student\Profile\Application\Profile\Commands\Update\Command;
use Project\Shared\Domain\ValueObject\UuidValueObject;

interface ProfileServiceInterface
{
    public function update(UuidValueObject $uuid, Command $command): void;
}
