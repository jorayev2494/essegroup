<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager;

use Project\Domains\Admin\Manager\Application\Manager\Queries\Index\Query;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Email;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface ManagerRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Manager;

    public function paginate(Query $httpQuery): Paginator;

    public function findByEmail(Email $email): ?Manager;

    public function save(Manager $member): void;

    public function delete(Manager $member): void;
}
