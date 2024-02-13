<?php

namespace Project\Domains\Admin\University\Application\Company\Subscribers;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasCreatedDomainEvent;
use Project\Domains\Admin\University\Domain\Company\Company;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public function __construct(
        private CompanyRepositoryInterface $universityRepository
    )
    {

    }

    #[\Override]
    public static function subscribedTo(): array
    {
        return [
            CompanyWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasCreatedDomainEvent $event): void
    {
        if ($this->universityRepository->existsByUuid(Uuid::fromValue($event->uuid))) {
            return;
        }

        $company = Company::fromPrimitives($event->uuid, $event->name, $event->domain, $event->status);

        $this->universityRepository->save($company);
    }
}
