<?php

namespace Project\Domains\Company\Profile\Domain\Profile\Services\Contracts;

use Project\Domains\Company\Profile\Application\Profile\Commands\Update\Command;
use Project\Shared\Domain\ValueObject\UuidValueObject;

interface ProfileServiceInterface
{
    public function update(UuidValueObject $uuid, Command $command): void;
}
