<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Country\Subscribers;

use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasChangedCompanyDomainEvent;
use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CountryWasChangedCompanyDomainEventSubscriber implements DomainEventSubscriberInterface
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
            CountryWasChangedCompanyDomainEvent::class,
        ];
    }

    public function __invoke(CountryWasChangedCompanyDomainEvent $event): void
    {
        $country = $this->countryRepository->findByUuid($event->uuid);

        if ($country === null) {
            return;
        }

        $country->setCompanyUuid($event->companyUuid);
        $this->countryRepository->save($country);
    }
}