<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Degree\Queries\List;

use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
       private DegreeRepositoryInterface $degreeRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->degreeRepository->list($query->filter)->translateItems()->toArray();
    }
}
