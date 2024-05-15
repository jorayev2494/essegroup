<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\WonStudent\Queries\Index;

use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudentRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WonStudentRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->paginate($query)->toArray();
    }
}
