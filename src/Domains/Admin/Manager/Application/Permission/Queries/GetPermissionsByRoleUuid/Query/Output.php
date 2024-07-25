<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Permission\Queries\GetPermissionsByRoleUuid\Query;

use Project\Domains\Admin\Manager\Domain\Permission\Permission;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionCollection;

readonly class Output
{
    private function __construct(
        private PermissionCollection $permissionCollection
    )
    { }

    public static function make(PermissionCollection $permissionCollection): self
    {
        return new self($permissionCollection);
    }

    public function toResponse(): array
    {
        return array_map(
            static fn (Permission $permission): array => PermissionOutput::make($permission)->toArray(),
            $this->permissionCollection->getValues()
        );
    }
}