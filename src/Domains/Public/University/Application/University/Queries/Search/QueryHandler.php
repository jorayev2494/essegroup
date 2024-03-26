<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\University\Queries\Search;

use Project\Domains\Public\University\Domain\University\Services\Contracts\UniversityServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UniversityServiceInterface $service
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->service->search($query);
    }
}
