<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Permission\Queries\Show\Output;

use Project\Domains\Admin\Manager\Domain\Permission\Permission;

readonly class Output
{
    private PermissionOutput $permissionOutput;

    private function __construct(Permission $permission)
    {
        $this->permissionOutput = PermissionOutput::make($permission);
    }

    public static function make(Permission $permission): self
    {
        return new self($permission);
    }

    public function toResponse(): array
    {
        return $this->permissionOutput->toArray();
    }
}