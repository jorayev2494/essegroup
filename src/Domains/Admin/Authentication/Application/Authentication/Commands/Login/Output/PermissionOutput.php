<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\Output;

use Project\Domains\Admin\Manager\Domain\Permission\Permission;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionTranslate;

readonly class PermissionOutput
{
    private Permission $permission;

    private function __construct(Permission $permission)
    {
        $this->permission = PermissionTranslate::execute($permission);
    }

    public static function make(Permission $permission): self
    {
        return new self($permission);
    }

    public function toArray(): array
    {
        return [
            'label' => $this->permission->getLabel()->value,
            'resource' => $this->permission->getResource()->value,
            'action' => $this->permission->getAction()->value,
            'is_active' => $this->permission->getIsActive(),
        ];
    }
}