<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Application\Company\Subscribers;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasCreatedDomainEvent;
use Project\Domains\Company\Company\Domain\Company\Company;
use Project\Domains\Company\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private CompanyRepositoryInterface $repository
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
        $company = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($company !== null) {
            return;
        }

        $company = Company::fromPrimitives(
            $event->uuid,
            $event->name,
            $event->email,
            $event->domain,
            $event->status,
        );

        $this->repository->save($company);
    }
}
