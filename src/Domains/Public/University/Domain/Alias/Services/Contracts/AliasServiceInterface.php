<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Domain\Alias\Services\Contracts;

use Project\Domains\Public\University\Application\Alias\Queries\List\Query;

interface AliasServiceInterface
{
    public function list(Query $query): array;
}
