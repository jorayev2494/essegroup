<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\DepartmentName\Services\Contracts;

use Project\Domains\Public\University\Application\DepartmentName\Queries\List\Query;

interface DepartmentNameServiceInterface
{
    public function list(Query $query): array;

    public function show(string $uuid): array;
}
