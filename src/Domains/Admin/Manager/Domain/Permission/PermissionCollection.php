<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Permission;

use Project\Shared\Domain\Collection;

class PermissionCollection extends Collection
{
    protected function type(): string
    {
        return Permission::class;
    }

    protected function translatorClass(): string
    {
        return PermissionTranslate::class;
    }
}