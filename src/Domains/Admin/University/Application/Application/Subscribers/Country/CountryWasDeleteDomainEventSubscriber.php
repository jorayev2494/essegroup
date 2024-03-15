<?php

namespace Project\Domains\Admin\University\Application\Application\Subscribers\Country;

use Project\Domains\Admin\University\Application\Application\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasDeleteDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CountryWasDeleteDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            CountryWasDeleteDomainEvent::class,
        ];
    }

    public function __invoke(CountryWasDeleteDomainEvent $event): void
    {
        $applications = $this->applicationRepository->findManyByCountryUuid($event->uuid);

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $applications->forAll(static function (int $id, Application $application) use($commandBus): bool {
            $commandBus->dispatch(new Command($application->getUuid()->value));

            return true;
        });
    }
}
