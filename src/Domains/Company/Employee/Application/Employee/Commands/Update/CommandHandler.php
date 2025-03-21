<?php

declare(strict_types=1);

namespace Project\Domains\Company\Employee\Application\Employee\Commands\Update;

use Project\Domains\Company\Employee\Domain\Employee\Services\Contracts\EmployeeServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeServiceInterface $service
    ) { }

    public function __invoke(Command $command): void
    {
        $this->service->update($command);
    }
}
