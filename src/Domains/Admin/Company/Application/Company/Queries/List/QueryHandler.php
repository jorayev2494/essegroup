<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Queries\List;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $repository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->repository->list()->toArray();
    }
}
