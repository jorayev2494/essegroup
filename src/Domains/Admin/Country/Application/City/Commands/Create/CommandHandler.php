<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\City\Commands\Create;

use Project\Domains\Admin\Country\Domain\City\City;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository,
        private TranslationColumnServiceInterface $translationColumnService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $country = $this->repository->findByUuid($command->countryUuid);

        $city = City::fromPrimitives($command->uuid, $command->companyUuid, $command->isActive);

        $this->translationColumnService->addTranslations($city, $command->translations);

        $country->addCity($city);
        $this->repository->save($country);
    }
}
