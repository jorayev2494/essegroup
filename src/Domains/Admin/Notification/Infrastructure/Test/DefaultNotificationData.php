<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Test;

use Project\Domains\Admin\Notification\Domain\Notification\Contracts\NotificationData;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\VOs\ManagerUuid;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\ManagerAdapter;

readonly class DefaultNotificationData extends NotificationData
{
    public const TYPE = 'default';

    private string $title;

    public function __construct(
        private string $managerUuid,
    ) {
        $this->title = 'notification.notify.test_title';
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['manager_uuid']
        );
    }

    public function toPayload(): array
    {
        return [
            'manager_uuid' => $this->managerUuid,
        ];
    }

    public function toNotification(): array
    {
        /** @var ManagerAdapter $managerAdapter */
        $managerAdapter = resolve(ManagerAdapter::class);
        $foundManager = $managerAdapter->findByUuid(ManagerUuid::fromValue($this->managerUuid));

        $manager = null;
        if ($foundManager !== null) {
            $manager = [
                'uuid' => $foundManager->uuid->value,
                'full_name' => $foundManager->fullName->fullName,
                'avatar' => $foundManager->avatar->value,
            ];
        }

        return [
            'title' => $this->title,
            'manager' => $manager,
        ];
    }
}