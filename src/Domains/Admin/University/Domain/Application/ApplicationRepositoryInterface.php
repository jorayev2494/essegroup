<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Project\Domains\Admin\University\Application\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\Application\Queries\ByStudentUuid\Query as ByStudentUuidQuery;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Shared\Domain\ValueObject\UuidValueObject;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface ApplicationRepositoryInterface
{
    public function paginate(IndexQuery $httpQuery): Paginator;

    public function getApplicationCountWhereCurrentStatusAre(array $statusUuids, array $companyUuids = []): ApplicationCollection;

    public function paginateByStudentUuid(ByStudentUuidQuery $httpQuery): Paginator;

    public function findByUuid(Uuid $uuid): ?Application;

    public function findManyByCompanyUuid(string $companyUuid): ApplicationCollection;

    public function findManyByUniversityUuid(string $universityUuid): ApplicationCollection;

    public function findManyByDepartmentUuid(string $departmentUuid): ApplicationCollection;

    public function findManyByCountryUuid(string $countryUuid): ApplicationCollection;

    public function save(Application $application): void;

    public function delete(Application $application): void;
}
