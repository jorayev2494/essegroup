<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Queries\Index;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Contracts\ArrayableInterface;
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
        return $this->repository->paginate($query);
    }
}
