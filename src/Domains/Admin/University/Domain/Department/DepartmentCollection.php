<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department;

use Project\Shared\Domain\Collection;

class DepartmentCollection extends Collection
{

    #[\Override]
    protected function type(): string
    {
        return Department::class;
    }

    #[\Override]
    protected function translatorClass(): string
    {
        return DepartmentTranslate::class;
    }

    #[\Override]
    public function translateItems(string $locale = 'en'): Collection
    {
        // TODO: Implement translateItems() method.
    }
}
