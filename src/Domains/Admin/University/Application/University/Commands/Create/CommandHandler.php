<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Commands\Create;

use Project\Domains\Admin\Country\Domain\City\CityRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\ValueObjects\YouTubeVideoId;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid as CountryUuid;
use Project\Domains\Admin\Country\Domain\City\ValueObjects\Uuid as CityUuid;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $universityRepository,
        private CountryRepositoryInterface $countryRepository,
        private CityRepositoryInterface $cityRepository,
        private TranslationColumnServiceInterface $translationColumnService,
        private LogoServiceInterface $logoService,
        private CoverServiceInterface $coverService,
        private EventBusInterface $eventBus
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $country = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->countryUuid));
        $city = $this->cityRepository->findByUuid(CityUuid::fromValue($command->cityUuid));

        $university = University::create(
            Uuid::fromValue($command->uuid),
            $country,
            $city,
            YouTubeVideoId::fromValue($command->youtubeVideoId)
        );

        $this->translationColumnService->addTranslations($university, $command->translations);
        $university->setIsOnTheCountryList($command->isOnTheCountryList);

        $this->logoService->update($university, $command->logo);
        $this->coverService->update($university, $command->cover);

        $this->universityRepository->save($university);
        $this->eventBus->publish(...$university->pullDomainEvents());
    }
}
