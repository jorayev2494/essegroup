<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Manager;

use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid;

interface ManagerRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Manager;

    public function save(Manager $manager): void;

    public function delete(Manager $manager): void;
}