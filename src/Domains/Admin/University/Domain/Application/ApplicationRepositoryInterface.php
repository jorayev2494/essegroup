<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface ApplicationRepositoryInterface
{
    public function paginate(BaseHttpQueryParams $httpQueryParams): Paginator;

    public function findByUuid(Uuid $uuid): ?Application;

    public function findManyByCompanyUuid(string $companyUuid): ApplicationCollection;

    public function findManyByUniversityUuid(string $universityUuid): ApplicationCollection;

    public function findManyByDepartmentUuid(string $departmentUuid): ApplicationCollection;

    public function findManyByCountryUuid(string $countryUuid): ApplicationCollection;

    public function save(Application $application): void;

    public function delete(Application $application): void;
}
