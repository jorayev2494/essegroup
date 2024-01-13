<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Subscribers;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct()
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
        dd(__METHOD__, $event);
    }
}
