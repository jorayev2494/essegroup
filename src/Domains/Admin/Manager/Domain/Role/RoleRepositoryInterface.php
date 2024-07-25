<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role;

use Project\Domains\Admin\Manager\Application\Role\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Manager\Application\Role\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface RoleRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Role;

    public function paginate(IndexQuery $indexQuery): Paginator;

    public function list(ListQuery $listQuery): RoleCollection;

    public function save(Role $role): void;

    public function delete(Role $role): void;
}