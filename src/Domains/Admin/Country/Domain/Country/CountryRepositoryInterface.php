<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\Country;

use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Value;
use Project\Domains\Admin\Country\Infrastructure\Country\Filters\HttpQueryFilterDTO;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface CountryRepositoryInterface
{
    public function list(HttpQueryFilterDTO $httpQueryFilterDTO): CountryCollection;

    public function paginate(BaseHttpQueryParams $httpQueryParams): Paginator;

    public function findByValueAndByCompanyUuid(Value $value, CompanyUuid $companyUuid): ?Country;

    public function findByUuidAndByCompanyUuid(string $uuid, CompanyUuid $companyUuid): ?Country;

    public function save(Country $country): void;
}
