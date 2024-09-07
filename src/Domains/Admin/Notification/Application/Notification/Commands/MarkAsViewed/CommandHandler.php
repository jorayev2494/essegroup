<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Commands\MarkAsViewed;

use Project\Domains\Admin\Notification\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\Notification\Services\Contracts\NotificationNotifyServiceInterface;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Uuid;
use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid as ManagerUuid;
use Project\Domains\Admin\Notification\Domain\Notification\NotificationRepositoryInterface;

readonly class CommandHandler
{
    public function __construct(
        private NotificationRepositoryInterface $repository,
        private ManagerRepositoryInterface $managerRepository,
        private NotificationNotifyServiceInterface $notificationNotifyService
    ) { }

    public function __invoke(Command $command): void
    {
        $notification = $this->repository->findByUuid(Uuid::fromValue($command->uuid));
        $manager = $this->managerRepository->findByUuid(ManagerUuid::fromValue($command->managerUuid));

        if ($notification === null || $manager === null) {
            return;
        }

        $this->notificationNotifyService->markAsViewed($notification, $manager);

        $this->repository->save($notification);
    }
}