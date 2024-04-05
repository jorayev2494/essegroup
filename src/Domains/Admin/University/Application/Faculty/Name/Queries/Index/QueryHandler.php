<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Name\Queries\Index;

use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FacultyNameRepositoryInterface $nameRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->nameRepository->paginate($query)
            ->translateItems(FacultyNameTranslate::class)
            ->toArray();
    }
}
