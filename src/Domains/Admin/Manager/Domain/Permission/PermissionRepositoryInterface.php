<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Permission;

use Project\Domains\Admin\Manager\Application\Permission\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\Manager\Application\Permission\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Id;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface PermissionRepositoryInterface
{
    public function paginate(IndexQuery $indexQuery): Paginator;

    public function list(ListQuery $listQuery): PermissionCollection;

    public function findById(Id $id): ?Permission;

    public function findManyByIds(array $ids): PermissionCollection;

    public function getByRoleUuids(string $roleUuid): PermissionCollection;

    public function save(Permission $permission): void;
}