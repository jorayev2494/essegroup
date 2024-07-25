<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Commands\Login\Output;

use Project\Domains\Admin\Manager\Domain\Role\Role;

readonly class Output
{
    private function __construct(
        private Role $role
    ) { }

    public static function make(Role $role): self
    {
        return new self($role);
    }

    public function toResponse(): array
    {
        return RoleOutput::make($this->role)->toArray();
    }
}