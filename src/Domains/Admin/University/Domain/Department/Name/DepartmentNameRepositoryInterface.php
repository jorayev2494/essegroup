<?php

namespace Project\Domains\Admin\University\Domain\Department\Name;

use Project\Domains\Admin\University\Application\DepartmentName\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface DepartmentNameRepositoryInterface
{
    public function paginate(Query $httpQuery): Paginator;

    public function list(): DepartmentNameCollection;

    public function findByUuid(Uuid $uuid): ?DepartmentName;

    public function save(DepartmentName $departmentName): void;

    public function delete(DepartmentName $departmentName): void;
}
