<?php

declare(strict_types=1);

namespace Project\Domains\Company\Student\Application\Student\Commands\Delete;

use Project\Domains\Company\Student\Domain\Student\Services\StudentService;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentService $service
    ) { }

    public function __invoke(Command $command): void
    {
        $this->service->delete(
            AuthManager::companyUuid(),
            UuidValueObject::fromValue($command->uuid)
        );
    }
}
