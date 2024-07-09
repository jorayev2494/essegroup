<?php

namespace Project\Domains\Admin\Currency\Domain\Currency;

use Project\Domains\Admin\Currency\Application\Currency\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Uuid;

interface CurrencyRepositoryInterface
{
    public function list(ListQuery $httpQuery): CurrencyCollection;

    public function findByUuid(Uuid $uuid): ?Currency;

    public function save(Currency $currency): void;
}
