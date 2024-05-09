<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Department\Services\Contracts;

use Project\Domains\Admin\University\Infrastructure\Department\Filters\QueryFilter;
use Project\Domains\Public\University\Application\Department\Queries\Index\Query as IndexQuery;

interface DepartmentServiceInterface
{

    public function index(IndexQuery $query): array;

    public function list(QueryFilter $queryFilter): array;
}
