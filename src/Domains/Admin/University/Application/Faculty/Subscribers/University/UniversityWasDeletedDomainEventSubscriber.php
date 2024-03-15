<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Subscribers\University;

use Project\Domains\Admin\University\Application\Faculty\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\Events\UniversityWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class UniversityWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private FacultyRepositoryInterface $facultyRepository
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
        $faculties = $this->facultyRepository->findManyByUniversityUuid($event->uuid);

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $faculties->forAll(static function (int $idx, Faculty $faculty) use($commandBus): bool {
            $commandBus->dispatch(new Command($faculty->getUuid()->value));

            return true;
        });
    }
}
