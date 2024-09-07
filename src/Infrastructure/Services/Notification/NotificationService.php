<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Notification;

use Project\Domains\Admin\Notification\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\Contracts\NotificationData;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Domains\Admin\Notification\Domain\Notification\NotificationRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Uuid;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Notification\Contracts\NotificationServiceInterface;
use Project\Infrastructure\Services\Notification\Drivers\BaseNotificationDriver;
use Project\Infrastructure\Services\Notification\Drivers\WSNotificationDriverInterface;
use Project\Infrastructure\Services\WS\Contracts\WSServiceInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid as ManagerUuid;

readonly class NotificationService implements NotificationServiceInterface
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private NotificationRepositoryInterface $repository,
        private ManagerRepositoryInterface $managerRepository,
        // private EventBusInterface $eventBus,
        private WSServiceInterface $WSService
    ) { }

    public function create(NotificationData $notificationData): Notification
    {
        $notification = Notification::create(
            Uuid::fromValue($this->uuidGenerator->generate()),
            $notificationData
        );

        $manager = $this->managerRepository->findByUuid(ManagerUuid::fromValue(AuthManager::managerUuid()->value));
        if ($manager !== null) {
            $notification->addViewedManagers($manager);
        }

        $this->repository->save($notification);
        // $this->eventBus->publish(...$notification->pullDomainEvents());
        /** @var EventBusInterface $eventBus */
        $eventBus = resolve(EventBusInterface::class);
        $eventBus->publish(...$notification->pullDomainEvents());

        return $notification;
    }

    public function notify(BaseNotificationDriver $notificationDriver): void
    {
        if ($notificationDriver instanceof WSNotificationDriverInterface) {
            $this->WSService->publish($notificationDriver->getWSChannel(), $notificationDriver->getWSData());
        }
    }
}