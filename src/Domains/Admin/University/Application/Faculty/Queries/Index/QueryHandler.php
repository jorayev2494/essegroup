<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Queries\Index;

use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\FacultyTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FacultyRepositoryInterface $facultyRepository,
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->facultyRepository->paginate($query)
            ->translateItems(FacultyTranslate::class)
            ->toArray();
    }
}
