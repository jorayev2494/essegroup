<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\University\Services\Contracts;

use Project\Domains\Public\University\Application\University\Queries\List\Query as ListQuery;
use Project\Domains\Public\University\Application\University\Queries\Search\Query as SearchQuery;

interface UniversityServiceInterface
{
    public function list(ListQuery $query): array;

    public function search(SearchQuery $query): array;
}
