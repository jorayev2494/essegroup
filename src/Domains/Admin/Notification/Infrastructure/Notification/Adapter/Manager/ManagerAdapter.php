<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\Contracts\ManagerApiInterface;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\ManagerDTO;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\VOs\ManagerUuid;

readonly class ManagerAdapter
{
    public function __construct(
        private ManagerApiInterface $api
    ) { }

    public function findByUuid(ManagerUuid $uuid): ?ManagerDTO
    {
        $manager = $this->api->findByUuid($uuid->value);

        if ($manager === null) {
            return null;
        }

        return ManagerDTO::makeFromArray($manager);
    }

    public function findMyByUuids(array $uuids): ArrayCollection
    {
        $managers = $this->api->findMyByUuids($uuids);

        return new ArrayCollection(
            array_map(ManagerDTO::makeFromArray(...), $managers)
        );
    }
}