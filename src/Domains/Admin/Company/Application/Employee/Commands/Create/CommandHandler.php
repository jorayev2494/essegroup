<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Employee\Commands\Create;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyNotFoundDomainException;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\Company\Domain\Employee\Employee;
use Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Email;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\FirstName;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\FullName;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\LastName;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Password;
use Project\Domains\Admin\Company\Domain\Employee\ValueObjects\Uuid;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private TokenGeneratorInterface $tokenGenerator,
        private AvatarServiceInterface $avatarService,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));

        $company ?? throw new CompanyNotFoundDomainException();

        $employee = Employee::create(
            Uuid::fromValue($command->uuid),
            FullName::make(
                FirstName::fromValue($command->firstName),
                LastName::fromValue($command->lastName)
            ),
            Email::fromValue($command->email),
            Password::fromValue($this->tokenGenerator->generate(6))
        );
        $this->avatarService->upload($employee, $command->avatar);

        $company->addEmployee($employee);

        $this->companyRepository->save($company);
        $this->eventBus->publish(...$employee->pullDomainEvents());
    }
}
