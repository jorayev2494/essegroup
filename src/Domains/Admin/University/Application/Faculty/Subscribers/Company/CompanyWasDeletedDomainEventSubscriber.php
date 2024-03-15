<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Subscribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Admin\University\Application\Faculty\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    function __construct(
        private FacultyRepositoryInterface $facultyRepository
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
        $faculties = $this->facultyRepository->findManyByCompanyUuid($event->uuid);

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $faculties->forAll(static function (int $idx, Faculty $faculty) use($commandBus): bool {
            $commandBus->dispatch(new Command($faculty->getUuid()->value));

            return true;
        });
    }
}
