<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Application\Commands\Create;

use Project\Domains\Public\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        // private ApplicationServiceInterface $applicationService
        // private CommandBusInterface $commandBus
    )
    {

    }

    public function __invoke(Command $command): void
    {
        dd($command);
        // $this->applicationService->create($command);
    }
}
