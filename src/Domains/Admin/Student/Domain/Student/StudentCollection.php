<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student;

use Project\Shared\Domain\Collection;

class StudentCollection extends Collection
{

    protected function type(): string
    {
        return Student::class;
    }

    protected function translatorClass(): string
    {
        return '';
    }
}
