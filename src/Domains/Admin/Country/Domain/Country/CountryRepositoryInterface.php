<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\Country;

use Project\Domains\Admin\Country\Application\Country\Queries\Index\Query;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Infrastructure\Country\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface CountryRepositoryInterface
{
    public function list(QueryFilter $httpQueryFilterDTO): CountryCollection;

    public function paginate(Query $httpQuery): Paginator;

    public function findByUuid(Uuid $uuid): ?Country;

    public function findManyByUuids(array $uuids): CountryCollection;

    public function save(Country $country): void;

    public function delete(Country $country): void;
}
