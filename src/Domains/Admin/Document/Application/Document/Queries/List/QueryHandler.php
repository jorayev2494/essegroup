<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Application\Document\Queries\List;

use Project\Domains\Admin\Document\Domain\Document\DocumentRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DocumentRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->list($query)
            ->translateItems()
            ->toArray();
    }
}
