<?php

namespace Project\Domains\Admin\University\Application\Country\Subscribers;

use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasCreatedDomainEvent;
use Project\Domains\Admin\University\Domain\Country\Country;
use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CountryWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
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
            CountryWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(CountryWasCreatedDomainEvent $event): void
    {
        $country = Country::fromPrimitives(
            $event->aggregateId(),
            $event->value,
            $event->iso,
            $event->companyUuid,
            $event->isActive
        );

        $this->countryRepository->save($country);
    }
}
