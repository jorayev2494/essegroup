<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\City\Queries\Index;

use Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface;
use Project\Domains\Admin\Country\Domain\City\CityTranslate;
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
        return $this->cityRepository->paginate($query)
            ->translateItems(CityTranslate::class)
            ->toArray();
    }
}
