<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Application\Manager\Commands\Create;

use Project\Domains\Company\Manager\Domain\Manager\Manager;
use Project\Domains\Company\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\CompanyUuid;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\Email;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository,
        private EventBusInterface $eventBus
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $manager = Manager::create(
            Uuid::fromValue($command->uuid),
            Email::fromValue($command->email),
            CompanyUuid::fromValue($command->companyUuid)
        );

        $this->repository->save($manager);
        $this->eventBus->publish(...$manager->pullDomainEvents());
    }
}
