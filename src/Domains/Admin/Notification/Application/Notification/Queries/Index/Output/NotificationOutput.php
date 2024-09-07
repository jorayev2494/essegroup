<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\Notification\Queries\Index\Output;

use Doctrine\Common\Collections\ArrayCollection;
use Project\Domains\Admin\Notification\Domain\Manager\Manager;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\ManagerDTO;
use Project\Domains\Admin\Notification\Infrastructure\Notification\NotificationHandlerFactory;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Contracts\ArrayableInterface;

readonly class NotificationOutput implements ArrayableInterface
{
    private function __construct(
        private Notification $notification,
        private ArrayCollection $viewedManagers
    ) { }

    public static function make(Notification $notification, ArrayCollection $viewedManagers): self
    {
        return new self($notification, $viewedManagers);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->notification->getUuid()->value,
            'type' => $this->notification->getType()->value,
            'payload' => NotificationHandlerFactory::make($this->notification)->toNotification(),
            'viewed_managers' => $this->getViewedManagers($this->notification)->map($this->viewedManagerMapper())->toArray(),
            'is_viewed' => $this->notification->getViewedManagers()->exists(
                static fn (int $key, Manager $manager): bool => $manager->getUuid()->isEquals(AuthManager::managerUuid())
            ),
            'created_at' => $this->notification->getCreatedAt()->getTimestamp(),
        ];
    }

    private function getViewedManagers(Notification $notification): ArrayCollection
    {
        return $this->viewedManagers->filter(
            static fn (ManagerDTO $managerDTO): bool => $notification->getViewedManagers()->exists(
                static fn (int $idx, Manager $manager): bool => $manager->getUuid()->isEquals($managerDTO->uuid)
            )
        );
    }

    private function viewedManagerMapper(): \Closure
    {
        return static fn (ManagerDTO $managerDTO): array => [
            'uuid' => $managerDTO->uuid->value,
            'full_name' => $managerDTO->fullName->fullName,
            'avatar' => $managerDTO->avatar->value,
        ];
    }
}