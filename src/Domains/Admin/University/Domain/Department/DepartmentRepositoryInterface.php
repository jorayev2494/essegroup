<?php

namespace Project\Domains\Admin\University\Domain\Department;

use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface DepartmentRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Department;

    public function paginate(BaseHttpQueryParams $httpQueryParams): Paginator;

    public function save(Department $department): void;

    public function delete(Department $department): void;
}
