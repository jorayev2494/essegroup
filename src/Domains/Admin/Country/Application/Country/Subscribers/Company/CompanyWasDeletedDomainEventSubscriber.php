<?php

namespace Project\Domains\Admin\Country\Application\Country\Subscribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Domains\Admin\Country\Application\Country\Commands\Delete\Command;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public function __construct(
        private CountryRepositoryInterface $countryRepository
    )
    {

    }

    #[\Override]
    public static function subscribedTo(): array
    {
        return [
            CompanyWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasDeletedDomainEvent $event): void
    {
        $countries = $this->countryRepository->findByCompanyUuid(CompanyUuid::fromValue($event->uuid));

        /** @var CommandBusInterface $commandBus */
        $commandBus = app()->make(CommandBusInterface::class);

        /** @var Country $country */
        foreach ($countries as $country) {
            $commandBus->dispatch(new Command($country->getUuid()));
        }
    }
}
