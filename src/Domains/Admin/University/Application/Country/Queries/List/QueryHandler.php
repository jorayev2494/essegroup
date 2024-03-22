<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Country\Queries\List;

use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->countryRepository->list($query->filter)->toArray();
    }
}
