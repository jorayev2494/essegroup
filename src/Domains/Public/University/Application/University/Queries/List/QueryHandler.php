<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\University\Queries\List;

use Project\Domains\Public\University\Domain\University\UniversityRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->repository->list($query->filters)->translateItems()->toArray();
    }
}
