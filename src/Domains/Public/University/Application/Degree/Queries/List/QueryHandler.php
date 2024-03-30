<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Degree\Queries\List;

use Project\Domains\Public\University\Domain\Degree\Services\Contracts\DegreeServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DegreeServiceInterface $service
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->service->list($query);
    }
}
