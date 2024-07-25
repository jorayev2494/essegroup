<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role\Services;

use Project\Domains\Admin\Manager\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Role\Role;
use Project\Domains\Admin\Manager\Domain\Role\Services\Contracts\RolePermissionServiceInterface;

readonly class RolePermissionService implements RolePermissionServiceInterface
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository
    ) { }

    public function updatePermissions(Role $role, array $permissionIds): void
    {
        $permissions = $this->permissionRepository->findManyByIds($permissionIds);

        $role->clearPermissions();
        $permissions->forEach($role->addPermission(...));
    }
}