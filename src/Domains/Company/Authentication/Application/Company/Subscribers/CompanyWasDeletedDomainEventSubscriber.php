<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Application\Company\Subscribers;

use Project\Domains\Company\Authentication\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository
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
        $company = $this->companyRepository->findByUuid($event->uuid);

        if ($company === null) {
            return;
        }

        $this->companyRepository->delete($company);
    }
}
