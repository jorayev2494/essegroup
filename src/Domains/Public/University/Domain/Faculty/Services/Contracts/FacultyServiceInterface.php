<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Faculty\Services\Contracts;

use Project\Domains\Admin\University\Infrastructure\Faculty\Filters\QueryFilter;

interface FacultyServiceInterface
{
    public function list(QueryFilter $queryFilter): array;

    public function show(string $uuid): array;
}
