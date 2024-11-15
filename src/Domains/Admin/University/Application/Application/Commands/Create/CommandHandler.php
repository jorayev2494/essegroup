<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Create;

use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid as CountryUuid;
use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid as LanguageUuid;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid as StudentUuid;
use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid as AliasUuid;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\Exceptions\StatusValueNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
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
        private StudentRepositoryInterface $studentRepository,
        private AliasRepositoryInterface $aliasRepository,
        private LanguageRepositoryInterface $languageRepository,
        private DegreeRepositoryInterface $degreeRepository,
        private CountryRepositoryInterface $countryRepository,
        private UniversityRepositoryInterface $universityRepository,
        private StatusValueRepositoryInterface $statusValueRepository,
        private ApplicationServiceInterface $service,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $student = $this->studentRepository->findByUuid(StudentUuid::fromValue($command->studentUuid));
        $language = $this->languageRepository->findByUuid(LanguageUuid::fromValue($command->languageUuid));
        $degree = $this->degreeRepository->findByUuid(DegreeUuid::fromValue($command->degreeUuid));
        $university = $this->universityRepository->findByUuid(UniversityUuid::fromValue($command->universityUuid));
        $alias = $command->aliasUuid ? $this->aliasRepository->findByUuid(AliasUuid::fromValue($command->aliasUuid))
                                     : null;
        $country = $command->countryUuid ? $this->countryRepository->findByUuid(CountryUuid::fromValue($command->countryUuid))
                                         : null;
        $statusValue = $this->statusValueRepository->findFirst();

        $statusValue ?? throw new StatusValueNotFoundDomainException();

        $application = Application::create(
            Uuid::fromValue($command->uuid),
            $student,
            $language,
            $degree,
            $university,
            Status::create($statusValue),
            $command->isAgreedToShareData,
            $command->creatorRole
        );

        if ($country === null) {
            $country = $university->getCountry()->isNotNull() === null ? $university->getCountry() : null;
        }

        $application->setAlias($alias);
        $application->setCountry($country);

        $this->service->addDepartments($application, $command->departmentUuids);

        $this->applicationRepository->save($application);
        $this->eventBus->publish(...$application->pullDomainEvents());
    }
}
