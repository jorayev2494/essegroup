<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Update;

use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid as CountryUuid;
use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid as LanguageUuid;
use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid as AliasUuid;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\Exceptions\ApplicationNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\StatusServiceInterface;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid as DegreeUuid;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid as UniversityUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository,
        private UniversityRepositoryInterface $universityRepository,
        private AliasRepositoryInterface $aliasRepository,
        private LanguageRepositoryInterface $languageRepository,
        private DegreeRepositoryInterface $degreeRepository,
        private CountryRepositoryInterface $countryRepository,
        private ApplicationServiceInterface $service,
        private StatusValueRepositoryInterface $statusValueRepository,
        private StatusServiceInterface $statusService,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $application = $this->applicationRepository->findByUuid(Uuid::fromValue($command->uuid));

        $application ?? throw new ApplicationNotFoundDomainException();

        $statusValue = $this->statusValueRepository->findByUuid(StatusValueUuid::fromValue($command->statusValueUuid));
        $alias = $this->aliasRepository->findByUuid(AliasUuid::fromValue($command->aliasUuid));
        $language = $this->languageRepository->findByUuid(LanguageUuid::fromValue($command->languageUuid));
        $degree = $this->degreeRepository->findByUuid(DegreeUuid::fromValue($command->degreeUuid));
        $country = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->countryUuid));
        $university = $this->universityRepository->findByUuid(UniversityUuid::fromValue($command->universityUuid));

        $application->changeAlias($alias);
        $application->changeLanguage($language);
        $application->changeDegree($degree);
        $application->changeCountry($country);
        $application->changeUniversity($university);

        $this->statusService->changeStatus($application, Status::create($statusValue), $command->statusNotes);
        $this->service->updateDepartments($application, $command->departmentUuids);

        $this->applicationRepository->save($application);
        $this->eventBus->publish(...$application->pullDomainEvents());
    }
}
