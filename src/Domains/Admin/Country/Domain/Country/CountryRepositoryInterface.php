<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\Country;

use Project\Domains\Admin\Country\Application\Country\Queries\Index\Query;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Value;
use Project\Domains\Admin\Country\Infrastructure\Country\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface CountryRepositoryInterface
{
    public function list(QueryFilter $httpQueryFilterDTO): CountryCollection;

    public function paginate(Query $httpQuery): Paginator;

    public function findByUuid(Uuid $uuid): ?Country;

    /**
     * @return CountryCollection<int, Country>
     */
    public function findByCompanyUuid(CompanyUuid $companyUuid): CountryCollection;

    public function findByValueAndByCompanyUuid(Value $value, CompanyUuid $companyUuid): ?Country;

    public function findByUuidAndByCompanyUuid(string $uuid, CompanyUuid $companyUuid): ?Country;

    public function save(Country $country): void;

    public function delete(Country $country): void;
}
