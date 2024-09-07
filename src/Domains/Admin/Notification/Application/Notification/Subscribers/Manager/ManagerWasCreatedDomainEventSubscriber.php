<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Subscribers\Manager;

use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Domains\Admin\Notification\Domain\Manager\Manager;
use Project\Domains\Admin\Notification\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ManagerWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ManagerWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerWasCreatedDomainEvent $event): void
    {
        $manager = Manager::make(Uuid::fromValue($event->uuid));

        $this->repository->save($manager);
    }
}