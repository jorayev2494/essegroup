<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Application\Manager\Subscribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Company\Manager\Application\Manager\Commands\Delete\Command;
use Project\Domains\Company\Manager\Domain\Manager\Manager;
use Project\Domains\Company\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\CompanyUuid;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository
    )
    {

    }

    public static function subscribedTo(): array
    {
        return [
            CompanyWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasDeletedDomainEvent $event): void
    {
        $managers = $this->repository->findManyByCompanyUuid(CompanyUuid::fromValue($event->uuid));

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $managers->forEach(
            static fn (Manager $manager) => $commandBus->dispatch(
                new Command(
                    $manager->getUuid()->value
                )
            )
        );
    }
}
