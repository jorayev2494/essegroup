<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager;

use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;

interface ManagerRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Manager;

    public function findByEmail(Email $email): ?Manager;

    public function save(Manager $member): void;
}
