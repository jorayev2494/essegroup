<?php

declare(strict_types=1);

namespace Project\Domains\Company\Employee\Application\Employee\Commands\Delete;

use Project\Domains\Company\Employee\Domain\Employee\Services\Contracts\EmployeeServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeServiceInterface $service
    ) { }

    public function __invoke(Command $command): void
    {
        $this->service->delete(
            AuthManager::companyUuid(),
            UuidValueObject::fromValue($command->uuid)
        );
    }
}
