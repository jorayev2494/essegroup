<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Country\Queries\Show;

use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\AnnouncementTranslate;
use Project\Domains\Admin\Country\Domain\Country\Exceptions\CountryNotFoundDomainException;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid;
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
        $country = $this->countryRepository->findByUuid(Uuid::fromValue($query->uuid));

        $country ?? throw new CountryNotFoundDomainException();

        return AnnouncementTranslate::execute($country)->toArrayWithTranslations();
    }
}
