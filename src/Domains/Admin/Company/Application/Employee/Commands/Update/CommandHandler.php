<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Employee\Commands\Update;

use Project\Domains\Admin\Company\Domain\Employee\EmployeeRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Employee\Exceptions\EmployeeNotFoundDomainException;
use Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Email;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\FirstName;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\LastName;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $repository,
        private AvatarServiceInterface $avatarService
    ) { }

    public function __invoke(Command $command): void
    {
        $employee = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $employee ?? throw new EmployeeNotFoundDomainException();

        $employee->getFullName()
            ->changeFirstName(FirstName::fromValue($command->firstName))
            ->changeLastName(LastName::fromValue($command->lastName));

        $employee->changeEmail(Email::fromValue($command->email));

        $this->avatarService->update($employee, $command->avatar);

        $this->repository->save($employee);
    }
}
