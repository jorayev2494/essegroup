<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Commands\Update;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyDomainAlreadyExistsDomainException;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyNameAlreadyExistsDomainException;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyNotFoundDomainException;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Domain;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Email;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $repository,
        private LogoServiceInterface $logoService,
        private EventBusInterface $eventBus,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $company = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        if ($company === null) {
            throw new CompanyNotFoundDomainException();
        }

        $company->changeName(Name::fromValue($command->name));
        $company->changeEmail(Email::fromValue($command->email));
        $company->changeDomain(Domain::fromValue($command->domain));
        $this->logoService->update($company, $command->logo);

        $this->repository->save($company);
        $this->eventBus->publish(...$company->pullDomainEvents());
    }
}
