<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Uuid as CityUuid;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\ValueObjects\YouTubeVideoId;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid as CountryUuid;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository,
        private CountryRepositoryInterface $countryRepository,
        private CityRepositoryInterface $cityRepository,
        private TranslationColumnServiceInterface $translationColumnService,
        private LogoServiceInterface $logoService,
        private CoverServiceInterface $coverService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $university = $this->repository->findByUuid(Uuid::fromValue($command->uuid));
        $country = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->countryUuid));
        $city = $this->cityRepository->findByUuid(CityUuid::fromValue($command->cityUuid));

        $university ?? throw new ModelNotFoundException();

        $university->changeCountry($country);
        $university->changeCity($city);
        $university->changeYouTubeVideoId(YouTubeVideoId::fromValue($command->youtubeVideoId));
        $university->changeIsOnTheCountryList($command->isOnTheCountryList);

        $this->translationColumnService->addTranslations($university, $command->translations);

        $this->logoService->update($university, $command->logo);
        $this->coverService->update($university, $command->cover);

        $this->repository->save($university);
    }
}
