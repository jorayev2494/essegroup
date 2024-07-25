<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role;

use Project\Shared\Domain\Collection;

class RoleCollection extends Collection
{
    protected function type(): string
    {
        return Role::class;
    }

    protected function translatorClass(): string
    {
        return RoleTranslate::class;
    }
}