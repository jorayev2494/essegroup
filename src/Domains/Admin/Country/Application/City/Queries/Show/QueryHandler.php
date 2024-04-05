<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\City\Queries\Show;

use Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface;
use Project\Domains\Admin\Country\Domain\City\CityTranslate;
use Project\Domains\Admin\Country\Domain\City\Exceptions\CityNotFoundDomainException;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Uuid;
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
        $city = $this->cityRepository->findByUuid(Uuid::fromValue($query->uuid));

        $city ?? throw new CityNotFoundDomainException();

        return CityTranslate::execute($city)->toArrayWithTranslations();
    }
}
