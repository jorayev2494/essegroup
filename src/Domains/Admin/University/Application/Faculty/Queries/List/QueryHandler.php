<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Queries\List;

use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FacultyRepositoryInterface $facultyRepository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->facultyRepository->list($query->filter)->translateItems()->toArray();
    }
}
