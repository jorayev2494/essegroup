<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Role\Queries\List\Output;

use Project\Domains\Admin\Manager\Domain\Role\Role;
use Project\Domains\Admin\Manager\Domain\Role\RoleCollection;

readonly class Output
{
    private function __construct(
        private RoleCollection $roleCollection
    ) { }

    public static function make(RoleCollection $roleCollection): self
    {
        return new self($roleCollection);
    }

    public function toResponse(): array
    {
        return array_map(
            static fn (Role $role) => RoleOutput::make($role)->toArray(),
            $this->roleCollection->getValues()
        );
    }
}