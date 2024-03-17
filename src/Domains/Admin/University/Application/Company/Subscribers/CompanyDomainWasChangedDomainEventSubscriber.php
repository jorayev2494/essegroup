<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Company\Subscribers;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyDomainWasChangedDomainEvent;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Domain;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyDomainWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private CompanyRepositoryInterface $repository
    )
    {

    }

    public static function subscribedTo(): array
    {
        return [
            CompanyDomainWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyDomainWasChangedDomainEvent $event): void
    {
        $company = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($company === null) {
            return;
        }

        $company->setDomain(Domain::fromValue($event->domain));

        $this->repository->save($company);
    }
}
