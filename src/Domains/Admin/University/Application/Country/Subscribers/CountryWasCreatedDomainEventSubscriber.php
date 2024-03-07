<?php

namespace Project\Domains\Admin\University\Application\Country\Subscribers;

use Project\Domains\Admin\Country\Domain\Country\Events\CountryWasCreatedDomainEvent;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Country\Country;
use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CountryWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public function __construct(
        private CountryRepositoryInterface $countryRepository,
         private CompanyRepositoryInterface $companyRepository
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
        $company = $this->companyRepository->findByUuid(Uuid::fromValue($event->companyUuid));

        if ($company === null) {
            return;
        }

        $country = Country::fromPrimitives(
            $event->uuid,
            $event->value,
            $event->iso,
            $event->isActive
        );

        $company->addCountry($country);
        $this->countryRepository->save($country);
    }
}
