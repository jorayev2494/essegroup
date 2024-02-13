<?php

namespace Project\Domains\Admin\University\Domain\Faculty;

use Project\Shared\Domain\Collection;

class FacultyCollection extends Collection
{
    #[\Override]
    protected function type(): string
    {
        return Faculty::class;
    }

    #[\Override]
    protected function translatorClass(): string
    {
        return FacultyTranslate::class;
    }
}
