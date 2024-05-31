<?php

declare(strict_types=1);

namespace Project\Domains\Public\Manager\Application\Manager\Queries\Show;

use Project\Domains\Public\Manager\Domain\Manager\Services\Contracts\ManagerServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ManagerServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->show($query->uuid);
    }
}
