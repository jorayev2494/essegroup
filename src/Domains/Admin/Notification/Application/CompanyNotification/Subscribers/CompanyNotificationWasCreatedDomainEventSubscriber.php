<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\CompanyNotification\Subscribers;

use Project\Domains\Admin\Notification\Domain\CompanyNotification\Events\NotificationWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyNotificationWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public static function subscribedTo(): array
    {
        return [
            NotificationWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(NotificationWasCreatedDomainEvent $event): void
    {

    }
}