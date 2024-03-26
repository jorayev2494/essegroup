<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\University\Services\Contracts;

use Project\Domains\Public\University\Application\University\Queries\Search\Query;

interface UniversityServiceInterface
{
    public function search(Query $query): array;
}
