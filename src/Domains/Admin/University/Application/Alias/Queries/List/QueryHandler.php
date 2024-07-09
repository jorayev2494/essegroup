<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Alias\Queries\List;

use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AliasRepositoryInterface $aliasRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        return $this->aliasRepository->list($query)
            ->translateItems()
            ->toArray();
    }
}
