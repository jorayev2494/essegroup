<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Country;

use Project\Shared\Domain\Collection;

class CountryCollection extends Collection
{
    #[\Override]
    protected function type(): string
    {
        return Country::class;
    }

    #[\Override]
    protected function translatorClass(): string
    {
        return '';
    }
}
