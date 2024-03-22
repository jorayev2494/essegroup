<?php

namespace Project\Domains\Admin\University\Domain\Department;

use Project\Domains\Admin\University\Application\Department\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Department\Filters\QueryFilter;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface DepartmentRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Department;

    public function findManyByUuids(array $findManyByUuids): DepartmentCollection;

    public function findManyByCompanyUuid(string $companyUuid): DepartmentCollection;

    public function findManyByUniversityUuid(string $universityUuid): DepartmentCollection;

    public function findManyByFacultyUuid(string $facultyUuid): DepartmentCollection;

    public function list(QueryFilter $queryFilter): DepartmentCollection;

    public function paginate(Query $httpQuery): Paginator;

    public function save(Department $department): void;

    public function delete(Department $department): void;
}
