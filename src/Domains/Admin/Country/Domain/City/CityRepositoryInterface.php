<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\City;

use Project\Domains\Admin\Country\Application\City\Queries\Index\Query;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Infrastructure\City\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface CityRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?City;

    public function paginate(Query $queryData): Paginator;

    public function list(QueryFilter $filter): CityCollection;

    public function save(City $city): void;

    public function delete(City $city): void;
}
