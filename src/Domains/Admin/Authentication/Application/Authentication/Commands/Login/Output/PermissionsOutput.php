<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\Output;

use Project\Domains\Admin\Manager\Domain\Permission\Permission;

readonly class PermissionsOutput
{
    private function __construct(
        private array $permissions
    ) { }

    public static function make(array $permissions): self
    {
        return new self($permissions);
    }

    public function toArray(): array
    {
        return array_map(
            static fn (Permission $permission): array => PermissionOutput::make($permission)->toArray(),
            $this->permissions
        );
    }
}