<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\City\Commands\Update;

use Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface;
use Project\Domains\Admin\Country\Domain\City\Exceptions\CityNotFoundDomainException;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Uuid;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid as CountryUuid;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository,
        private CityRepositoryInterface $cityRepository,
        private TranslationColumnServiceInterface $translationColumnService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $city = $this->cityRepository->findByUuid(Uuid::fromValue($command->uuid));

        $city ?? throw new CityNotFoundDomainException();

        $country = $this->repository->findByUuid(CountryUuid::fromValue($command->countryUuid));

        $city->setCountry($country);

        $this->translationColumnService->addTranslations($city, $command->translations);
        $this->cityRepository->save($city);
    }
}
