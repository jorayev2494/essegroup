<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Faculty\Queries\List;

use Project\Domains\Public\University\Domain\Faculty\Services\Contracts\FacultyServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FacultyServiceInterface $facultyService
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->facultyService->list($query->httpQueryFilter);
    }
}
