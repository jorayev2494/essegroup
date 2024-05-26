<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Domain\ApplicationStatusValue\Services\Contracts;

use Project\Domains\Student\University\Application\ApplicationStatusValue\Queries\List\Query;

interface ApplicationStatusValueServiceInterface
{
    public function list(Query $query): array;
}
