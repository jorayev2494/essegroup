<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Degree;

use Project\Shared\Domain\Collection;

class DegreeCollection extends Collection
{
    #[\Override]
    protected function type(): string
    {
        return Degree::class;
    }

    #[\Override]
    protected function translatorClass(): string
    {
        return DegreeTranslate::class;
    }
}
