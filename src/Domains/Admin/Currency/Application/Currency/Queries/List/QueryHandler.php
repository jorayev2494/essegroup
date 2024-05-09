<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Application\Currency\Queries\List;

use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;

readonly class QueryHandler
{
    public function __construct(
        private CurrencyRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->list($query)->toArray();
    }
}
