<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Subscribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Admin\University\Application\Department\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    function __construct(
        private DepartmentRepositoryInterface $departmentRepository
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
        $departments = $this->departmentRepository->findManyByCompanyUuid($event->uuid);

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $departments->forAll(static function (int $idx, Department $department) use($commandBus): bool {
            $commandBus->dispatch(new Command($department->getUuid()->value));

            return true;
        });
    }
}
