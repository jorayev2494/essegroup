<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\Contest;

use Project\Shared\Domain\Collection;

class ContestCollection extends Collection
{

    protected function type(): string
    {
        return Contest::class;
    }

    protected function translatorClass(): string
    {
        return ContestTranslate::class;
    }
}
