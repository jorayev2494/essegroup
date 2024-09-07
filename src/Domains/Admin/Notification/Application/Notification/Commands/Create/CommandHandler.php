<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Commands\Create;

use Project\Domains\Admin\Notification\Infrastructure\Test\DefaultNotificationData;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Infrastructure\Services\Notification\Contracts\NotificationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private NotificationServiceInterface $notificationService
    ) { }

    public function __invoke(Command $command): void
    {
        $notificationData = new DefaultNotificationData(
            AuthManager::managerUuid()->value
        );

        $this->notificationService->create($notificationData);
    }
}