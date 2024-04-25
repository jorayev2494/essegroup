<?php

declare(strict_types=1);

namespace Project\Domains\Company\Profile\Domain\Profile\Services;

use Project\Domains\Admin\Company\Application\Employee\Commands\Update\Command as UpdateCommand;
use Project\Domains\Company\Profile\Application\Profile\Commands\Update\Command;
use Project\Domains\Company\Profile\Domain\Profile\Services\Contracts\ProfileServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

class ProfileService implements ProfileServiceInterface
{
    public function update(UuidValueObject $uuid, Command $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new UpdateCommand(
                $uuid->value,
                $command->firstName,
                $command->lastName,
                $command->email,
                $command->avatar
            )
        );
    }
}
