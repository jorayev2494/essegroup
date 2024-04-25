<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Employee\Commands\Delete;

use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Employee\Exceptions\EmployeeNotFoundDomainException;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $repository
    ) { }

    public function __invoke(Command $command): void
    {
        $employee = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $employee ?? throw new EmployeeNotFoundDomainException();

        $this->repository->delete($employee);
    }
}
