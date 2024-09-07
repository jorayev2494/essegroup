<?php

namespace Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\Contracts;

interface ManagerApiInterface
{
    public function findByUuid(string $uuid): ?array;

    public function findMyByUuids(array $uuids): array;
}