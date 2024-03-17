<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Company\Subscribers;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyNameWasChangedDomainEvent;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyNameWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private CompanyRepositoryInterface $repository
    )
    {

    }

    public static function subscribedTo(): array
    {
        return [
            CompanyNameWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyNameWasChangedDomainEvent $event): void
    {
        $company = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($company === null) {
            return;
        }

        $company->setName(Name::fromValue($event->name));

        $this->repository->save($company);
    }
}
