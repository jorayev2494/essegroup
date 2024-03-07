<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Application\Company\Subscribers;

use Project\Domains\Company\Authentication\Domain\Company\Company;
use Project\Domains\Company\Authentication\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
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
            CompanyWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasCreatedDomainEvent $event): void
    {
        $this->companyRepository->save(
            Company::fromPrimitives($event->uuid)
        );
    }
}
