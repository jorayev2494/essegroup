<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Degree\Services\Contracts;

use Project\Domains\Public\University\Application\Degree\Queries\List\Query;

interface DegreeServiceInterface
{
    public function list(Query $query): array;
}
