<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\Output;

use Project\Domains\Admin\Manager\Domain\Role\Role;
use Project\Domains\Admin\Manager\Domain\Role\RoleTranslate;

readonly class RoleOutput
{
    private Role $role;

    private function __construct(Role $role)
    {
        $this->role = RoleTranslate::execute($role);
    }

    public static function make(Role $role): self
    {
        return new self($role);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->role->getName()->value,
            'permissions' => $this->role->getIsActive() ? PermissionsOutput::make($this->role->getPermissions())->toArray() : null,
            'is_admin' => $this->role->isAdmin(),
            'is_active' => $this->role->getIsActive(),
        ];
    }
}