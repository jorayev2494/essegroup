<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Subscribers;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\Events\NotificationWasCreatedDomainEvent;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Domains\Admin\Notification\Domain\Notification\NotificationRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Uuid;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Notification\Contracts\NotificationServiceInterface;
use Project\Infrastructure\Services\Notification\Drivers\NotificationDriver;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class NotificationWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private ManagerRepositoryInterface $managerRepository,
        private NotificationRepositoryInterface $notificationRepository,
        private NotificationServiceInterface $notificationService
    ) { }

    public static function subscribedTo(): array
    {
        return [
            NotificationWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(NotificationWasCreatedDomainEvent $event): void
    {
        $notification = $this->notificationRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($notification === null) {
            return;
        }

        $authManagerUuid = AuthManager::managerUuid();
        $this->managerRepository->getActiveManagers()
            ->filter(static fn (Manager $manager): bool => $manager->getUuid()->isNotEquals($authManagerUuid))
            ->forEach($this->handler($notification));
    }

    private function handler(Notification $notification): \Closure
    {
        return function (Manager $manager) use($notification): void {
            $this->notificationService->notify(
                new NotificationDriver(
                    $manager,
                    $notification
                )
            );
        };
    }
}