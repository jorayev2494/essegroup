<?php

namespace Project\Domains\Admin\University\Application\Country\Subscribers;

use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasDeleteDomainEvent;
use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CountryWasDeleteDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    )
    {

    }

    #[\Override]
    public static function subscribedTo(): array
    {
        return [
            CountryWasDeleteDomainEvent::class,
        ];
    }

    public function __invoke(CountryWasDeleteDomainEvent $event): void
    {
        $country = $this->countryRepository->findByUuid($event->uuid);

        if ($country === null) {
            return;
        }

        $this->countryRepository->delete($country);
    }
}
