<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\Contest\Queries\Participants;

use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->paginateParticipants($query)->toArray();
    }
}
