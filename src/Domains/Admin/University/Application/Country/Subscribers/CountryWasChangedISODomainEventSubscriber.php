<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Country\Subscribers;

use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedISODomainEvent;
use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CountryWasChangedISODomainEventSubscriber implements DomainEventSubscriberInterface
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
            CountryWasChangedISODomainEvent::class,
        ];
    }

    public function __invoke(CountryWasChangedISODomainEvent $event): void
    {
        $country = $this->countryRepository->findByUuid($event->uuid);

        if ($country === null) {
            return;
        }

        $country->setISO($event->iso);
        $this->countryRepository->save($country);
    }
}
