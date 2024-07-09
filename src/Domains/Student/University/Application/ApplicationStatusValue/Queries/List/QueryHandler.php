<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Application\ApplicationStatusValue\Queries\List;

use Project\Domains\Student\University\Domain\ApplicationStatusValue\Services\Contracts\ApplicationStatusValueServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ApplicationStatusValueServiceInterface $service
    ) { }

    public function __invoke(Query $query): array
    {
        return $this->service->list($query);
    }
}
