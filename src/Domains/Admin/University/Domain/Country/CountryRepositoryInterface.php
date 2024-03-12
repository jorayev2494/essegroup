<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Country;

use Project\Domains\Admin\University\Application\Country\Queries\Index\Query;
use Project\Domains\Admin\University\Infrastructure\Country\Filters\HttpQueryFilterDTO;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface CountryRepositoryInterface
{
    public function findByUuid(string $uuid): ?Country;

    public function paginate(Query $httpQuery): Paginator;

    public function list(HttpQueryFilterDTO $queryFilterDTO): CountryCollection;

    public function save(Country $country): void;

    public function delete(Country $country): void;
}
