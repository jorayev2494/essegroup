<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Application\Manager\Commands\Delete;

use Project\Domains\Company\Manager\Domain\Manager\Exceptions\ManagerNotFoundDomainException;
use Project\Domains\Company\Manager\Domain\Manager\ManagerRepositoryInterface;
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
        $manager = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $manager ?? throw new ManagerNotFoundDomainException();

        $manager->delete();
        $this->repository->delete($manager);
        $this->eventBus->publish(...$manager->pullDomainEvents());
    }
}
