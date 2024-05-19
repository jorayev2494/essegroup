<?php

namespace Project\Domains\Public\Company\Domain\Company\Services\Contracts;

use Project\Domains\Public\Company\Application\Company\Queries\List\Query as ListQuery;

interface CompanyServiceInterface
{
    public function list(ListQuery $query): array;
}
