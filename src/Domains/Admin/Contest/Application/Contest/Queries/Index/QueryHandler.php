<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\Contest\Queries\Index;

use Project\Domains\Admin\Contest\Domain\Contest\ContestRepositoryInterface;
use Project\Domains\Admin\Contest\Domain\Contest\ContestTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ContestRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->paginate($query)
            ->translateItems(ContestTranslate::class)
            ->toArray();
    }
}
