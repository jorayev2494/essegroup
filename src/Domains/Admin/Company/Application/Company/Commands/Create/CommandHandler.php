<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Commands\Create;

use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyDomainAlreadyExistsDomainException;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyNameAlreadyExistsDomainException;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Domain;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $repository,
        private EventBusInterface $eventBus,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        // dd($command);
        $company = $this->repository->findByName(Name::fromValue($command->name));

        if ($company !== null) {
            throw new CompanyNameAlreadyExistsDomainException();
        }

        $company = $this->repository->findByDomain(Domain::fromValue($command->domain));

        if ($company !== null) {
            throw new CompanyDomainAlreadyExistsDomainException();
        }

        $company = Company::create(
            Uuid::fromValue($command->uuid),
            Name::fromValue($command->name),
            Domain::fromValue($command->domain)
        );

        $this->repository->save($company);
        $this->eventBus->publish(...$company->pullDomainEvents());
    }
}
