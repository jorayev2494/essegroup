<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Domain\Department\Services\Contracts;

use Project\Domains\Student\University\Application\Department\Queries\Index\Query;
use Project\Shared\Domain\ValueObject\UuidValueObject;

interface DepartmentServiceInterface
{
    public function index(UuidValueObject $companyUuid, Query $query): array;
}
