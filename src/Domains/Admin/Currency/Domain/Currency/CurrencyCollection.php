<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Domain\Currency;

use Project\Shared\Domain\Collection;

class CurrencyCollection extends Collection
{

    protected function type(): string
    {
        return Currency::class;
    }

    protected function translatorClass(): string
    {
        return '';
    }
}
