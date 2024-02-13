<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Queries\Index;

use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->applicationRepository->paginate($query)->toArray();
    }
}
