<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role\Services\Contracts;

use Project\Domains\Admin\Manager\Domain\Role\Role;

interface RolePermissionServiceInterface
{
    public function updatePermissions(Role $role, array $permissionIds): void;
}