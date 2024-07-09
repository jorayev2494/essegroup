<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Subscribers\Department;

use Project\Domains\Admin\University\Application\Application\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Events\ApplicationWasDeletedFromDepartmentDomainEvent;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ApplicationWasDeletedFromDepartmentDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository
    )
    {

    }

    public static function subscribedTo(): array
    {
        return [
            ApplicationWasDeletedFromDepartmentDomainEvent::class,
        ];
    }

    public function __invoke(ApplicationWasDeletedFromDepartmentDomainEvent $event): void
    {
        $application = $this->applicationRepository->findByUuid(Uuid::fromValue($event->applicationUuid));

        if ($application === null) {
            return;
        }

        if ($application->getDepartments()->isEmpty()) {
            /** @var CommandBusInterface $commandBus */
            $commandBus = resolve(CommandBusInterface::class);
            $commandBus->dispatch(new Command($application->getUuid()->value));
        }
    }
}
