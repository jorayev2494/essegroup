<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Subscribers\University;

use Project\Domains\Admin\University\Application\Application\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\Events\UniversityWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class UniversityWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    function __construct(
        private ApplicationRepositoryInterface $applicationRepository
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
        $applications = $this->applicationRepository->findManyByUniversityUuid($event->uuid);

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $applications->forAll(static function (int $idx, Application $application) use($commandBus): bool {
            $commandBus->dispatch(new Command($application->getUuid()->value));

            return true;
        });
    }
}
