<?php

namespace Project\Domains\Public\University\Domain\Application\Services;

use Project\Domains\Public\University\Application\Application\Commands\Create\Command;
use Project\Domains\Admin\University\Application\Application\Commands\Create\Command as CreateCommand;
use Project\Domains\Public\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

readonly class ApplicationService implements ApplicationServiceInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    )
    {

    }

    #[\Override]
    public function create(Command $command): void
    {
        dd($command);
        $this->commandBus->dispatch(
            new CreateCommand(
                $command->uuid,
                $command->email,
                $command->phone,
                $command->passport,
                $command->passportTranslation,
                $command->schoolAttestat,
                $command->schoolAttestatTranslation,
                $command->transcript,
                $command->transcriptTranslation,
                $command->equivalenceDocument,
                $command->biometricPhoto,
            )
        );
    }
}
