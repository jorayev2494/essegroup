<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\City;

use Project\Shared\Domain\Collection;

class CityCollection extends Collection
{
    protected function type(): string
    {
        return City::class;
    }

    protected function translatorClass(): string
    {
        return CityTranslate::class;
    }
}
