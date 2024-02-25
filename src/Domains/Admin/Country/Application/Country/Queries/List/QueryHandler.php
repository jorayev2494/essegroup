<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Queries\List;

use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    )
    {

    }

    public function __invoke(Query $query): array
    {
        return $this->countryRepository->list($query->httpQueryFilter)->toArray();
    }
}
