<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Queries\Search;

use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->repository->search($query->paginate, $query->search, $query->filter)
                    ->translateItems(UniversityTranslate::class)
                    ->toArray();
    }
}
