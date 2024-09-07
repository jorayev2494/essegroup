<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Subscribers\Manager;

use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasDeletedDomainEvent;
use Project\Domains\Admin\Notification\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ManagerWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ManagerWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerWasDeletedDomainEvent $event): void
    {
        $manager = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($manager === null) {
            return;
        }

        $this->repository->delete($manager);
    }
}