<?php

declare(strict_types=1);

namespace Project\Domains\Company\Student\Application\Student\Commands\Create;

use Project\Domains\Company\Student\Domain\Student\Services\StudentService;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentService $service
    ) { }

    public function __invoke(Command $command): void
    {
        $this->service->create(
            AuthManager::companyUuid(),
            $command
        );
    }
}
