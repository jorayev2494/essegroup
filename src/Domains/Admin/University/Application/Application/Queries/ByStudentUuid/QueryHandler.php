<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Queries\ByStudentUuid;

use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->paginateByStudentUuid($query)->toArray();
    }
}
