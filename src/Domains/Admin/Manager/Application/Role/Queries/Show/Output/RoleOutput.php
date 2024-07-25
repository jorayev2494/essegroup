<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Role\Queries\Show\Output;

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
            'uuid' => $this->role->getUuid()->value,
            'name' => $this->role->getName()->value,
            'translations' => $this->role->translationsToArray(),
            'is_active' => $this->role->getIsActive(),
            'created_at' => $this->role->getCreatedAt()->getTimestamp(),
            'updated_at' => $this->role->getUpdatedAt()->getTimestamp(),
        ];
    }
}