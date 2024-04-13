<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Application\Services;

use Project\Domains\Public\University\Application\Application\Commands\Create\Command;
use Project\Domains\Admin\University\Application\Application\Commands\Create\Command as CreateCommand;
use Project\Domains\Public\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

readonly class ApplicationService implements ApplicationServiceInterface
{
    #[\Override]
    public function create(Command $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $commandBus->dispatch(
            new CreateCommand(
                $command->uuid,
                $command->studentUuid,
                $command->aliasUuid,
                $command->languageUuid,
                $command->degreeUuid,
                $command->countryUuid,
                $command->universityUuid,
                $command->departmentUuids,
                $command->isAgreedToShareData,
                'client'
            )
        );
    }
}
