<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department\Name;

use Project\Shared\Domain\Collection;

class DepartmentNameCollection extends Collection
{

    protected function type(): string
    {
        return DepartmentName::class;
    }

    protected function translatorClass(): string
    {
        return DepartmentNameTranslate::class;
    }
}
