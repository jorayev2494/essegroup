<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\City\Queries\List;

use Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CityRepositoryInterface $cityRepository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->cityRepository->list($query->filter)->translateItems()->toArray();
    }
}
