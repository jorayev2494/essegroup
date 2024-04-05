<?php

namespace Project\Domains\Admin\Country\Domain\Country;

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
        return CountryTranslate::class;
    }
}
