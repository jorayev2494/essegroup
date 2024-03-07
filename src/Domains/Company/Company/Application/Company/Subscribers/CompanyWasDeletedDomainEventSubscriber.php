<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Application\Company\Subscribers;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Company\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Company\Company\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
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
            CompanyWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasDeletedDomainEvent $event): void
    {
        $company = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($company === null) {
            return;
        }

        $this->repository->delete($company);
    }
}
