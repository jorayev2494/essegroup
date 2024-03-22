<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Country\Queries\List;

use Project\Domains\Public\University\Domain\Country\Services\Contracts\CountryServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CountryServiceInterface $countryService
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->countryService->list($query->filter);
    }
}
