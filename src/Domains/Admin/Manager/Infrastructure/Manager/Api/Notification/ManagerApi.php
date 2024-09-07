<?php

namespace Project\Domains\Admin\Manager\Infrastructure\Manager\Api\Notification;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\Contracts\ManagerApiInterface;

readonly class ManagerApi implements ManagerApiInterface
{
    public function __construct(
        private ManagerRepositoryInterface $repository
    ) { }

    public function findByUuid(string $uuid): ?array
    {
        $manager = $this->repository->findByUuid(Uuid::fromValue($uuid));

        if ($manager === null) {
            return null;
        }

        return [
            'uuid' => $manager->getUuid()->value,
            'first_name' => $manager->getFullName()->getFirstName()->value,
            'last_name' => $manager->getFullName()->getLastName()->value,
            'avatar' => $manager->getAvatar()?->toArray(),
        ];
    }

    public function findMyByUuids(array $uuids): array
    {
        $managers = $this->repository->findMyByUuids($uuids);

        $result = [];
        $managers->forEach(static function (Manager $manager) use(&$result): void {
            $result[] = [
                'uuid' => $manager->getUuid()->value,
                'first_name' => $manager->getFullName()->getFirstName()->value,
                'last_name' => $manager->getFullName()->getLastName()->value,
                'avatar' => $manager->getAvatar()?->toArray(),
            ];
        });

        return $result;
    }
}