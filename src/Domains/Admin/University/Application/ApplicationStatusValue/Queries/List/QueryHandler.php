<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\List;

use Project\Domains\Admin\University\Domain\Application\StatusEnum;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StatusValueRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->repository->list()->translateItems()->toArray();
    }
}