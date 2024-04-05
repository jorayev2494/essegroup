<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty\Name;

use Project\Shared\Domain\Collection;

class FacultyNameCollection extends Collection
{
    protected function type(): string
    {
        return FacultyName::class;
    }

    protected function translatorClass(): string
    {
        return FacultyNameTranslate::class;
    }
}
