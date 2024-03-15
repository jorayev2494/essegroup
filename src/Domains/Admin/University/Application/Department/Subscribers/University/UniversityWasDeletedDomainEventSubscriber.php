<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Subscribers\University;

use Project\Domains\Admin\University\Application\Department\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\Events\UniversityWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class UniversityWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            UniversityWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(UniversityWasDeletedDomainEvent $event): void
    {
        $departments = $this->departmentRepository->findManyByUniversityUuid($event->uuid);

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $departments->forAll(static function (int $idx, Department $department) use($commandBus): bool {
            $commandBus->dispatch(new Command($department->getUuid()->value));

            return true;
        });
    }
}
