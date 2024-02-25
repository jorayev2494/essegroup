<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Country;

use Project\Domains\Admin\University\Infrastructure\Country\Filters\HttpQueryFilterDTO;

interface CountryRepositoryInterface
{
    public function findByUuid(string $uuid): ?Country;

    public function list(HttpQueryFilterDTO $queryFilterDTO): CountryCollection;

    public function save(Country $country): void;
}
