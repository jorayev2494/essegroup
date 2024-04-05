<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\FacultyName\Queries\List;

use Project\Domains\Public\University\Domain\FacultyName\Services\Contracts\FacultyNameServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FacultyNameServiceInterface $service
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->service->list($query);
    }
}
