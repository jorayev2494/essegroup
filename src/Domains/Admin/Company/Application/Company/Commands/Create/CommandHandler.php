<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Commands\Create;

use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyDomainAlreadyExistsDomainException;
use Project\Domains\Admin\Company\Domain\Company\Exceptions\CompanyNameAlreadyExistsDomainException;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Email;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\Company\Domain\Status\Status;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $repository,
        private LogoServiceInterface $logoService,
        private EventBusInterface $eventBus,
        private UuidGeneratorInterface $uuidGenerator
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $company = Company::create(
            Uuid::fromValue($command->uuid),
            Name::fromValue($command->name),
            Email::fromValue($command->email),
            Status::fromPrimitives($this->uuidGenerator->generate(), 'new'),
            $command->isMain
        );

        $this->logoService->upload($company, $command->logo);

        $this->repository->save($company);
        $this->eventBus->publish(...$company->pullDomainEvents());
    }
}
