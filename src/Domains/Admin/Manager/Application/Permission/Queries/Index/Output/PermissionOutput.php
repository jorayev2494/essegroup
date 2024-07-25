<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Permission\Queries\Index\Output;

use Project\Domains\Admin\Manager\Domain\Permission\Permission;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionTranslate;
use Project\Shared\Contracts\ArrayableInterface;

readonly class PermissionOutput implements ArrayableInterface
{
    private Permission $permission;

    public function __construct(Permission $permission)
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
            'id' => $this->permission->getId()->value,
            'label' => $this->permission->getLabel()->value,
            'resource' => $this->permission->getResource()->value,
            'action' => $this->permission->getAction()->value,
            'is_active' => $this->permission->getIsActive(),
            'created_at' => $this->permission->getCreatedAt()->getTimestamp(),
            'updated_at' => $this->permission->getUpdatedAt()->getTimestamp(),
        ];
    }
}