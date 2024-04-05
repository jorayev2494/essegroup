<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\DepartmentName\Commands\Delete;

use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Name\Exceptions\DepartmentNameNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DepartmentNameRepositoryInterface $nameRepository
    ) {

    }

    public function __invoke(Command $command): void
    {
        $departmentName = $this->nameRepository->findByUuid(Uuid::fromValue($command->uuid));

        $departmentName ?? throw new DepartmentNameNotFoundDomainException();

        $this->nameRepository->delete($departmentName);
    }
}
