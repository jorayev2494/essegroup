<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Country\Subscribers;

use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedValueDomainEvent;
use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CountryWasChangedValueDomainEventSubscriber implements DomainEventSubscriberInterface
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
            CountryWasChangedValueDomainEvent::class,
        ];
    }

    public function __invoke(CountryWasChangedValueDomainEvent $event): void
    {
        $country = $this->countryRepository->findByUuid($event->uuid);

        if ($country === null) {
            return;
        }

        $country->setValue($event->value);
        $this->countryRepository->save($country);
    }
}
