<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\City\Queries\List;

use Project\Domains\Public\University\Domain\City\Services\Contracts\CityServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CityServiceInterface $service
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->service->list($query);
    }
}
