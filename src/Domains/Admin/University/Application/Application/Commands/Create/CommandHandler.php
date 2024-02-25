<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Create;

use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Email;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FatherName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FriendPhone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FullName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\HomeAddress;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\MotherName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\PassportNumber;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Phone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid as UniversityUuid;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\Contracts\BiometricPhotoServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\Contracts\PassportServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts\PassportTranslationServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\Contracts\SchoolAttestatServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts\TranscriptServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use DateTimeImmutable;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository,
        private UniversityRepositoryInterface $universityRepository,
        private FacultyRepositoryInterface $facultyRepository,
        private CountryRepositoryInterface $countryRepository,
        private PassportServiceInterface $passportService,
        private PassportTranslationServiceInterface $passportTranslationService,
        private SchoolAttestatServiceInterface $schoolAttestatService,
        private SchoolAttestatTranslationServiceInterface $schoolAttestatTranslationService,
        private TranscriptServiceInterface $transcriptService,
        private TranscriptTranslationServiceInterface $transcriptTranslationService,
        private EquivalenceDocumentServiceInterface $equivalenceDocumentService,
        private BiometricPhotoServiceInterface $biometricPhotoService,
        private AdditionalDocumentServiceInterface $additionalDocumentService,
        private EventBusInterface $eventBus
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $university = $this->universityRepository->findByUuid(UniversityUuid::fromValue($command->universityUuid));
        $faculty = $this->facultyRepository->findByUuid(FacultyUuid::fromValue($command->facultyUuid));
        $country = $this->countryRepository->findByUuid($command->countryUuid);

        $application = Application::create(
            Uuid::fromValue($command->uuid),
            FullName::fromValue($command->fullName),
            new DateTimeImmutable($command->birthday),
            PassportNumber::fromValue($command->passportNumber),
            Email::fromValue($command->email),
            Phone::fromValue($command->phone),
            $university,
            $faculty,
            $country,
            $command->isAgreedToShareData,
        );

        $this->passportService->upload($application, $command->passport);
        $this->passportTranslationService->upload($application, $command->passportTranslation);
        $this->schoolAttestatService->upload($application, $command->schoolAttestat);
        $this->schoolAttestatTranslationService->upload($application, $command->schoolAttestatTranslation);
        $this->transcriptService->upload($application, $command->transcript);
        $this->transcriptTranslationService->upload($application, $command->transcriptTranslation);
        $this->equivalenceDocumentService->upload($application, $command->equivalenceDocument);
        $this->biometricPhotoService->upload($application, $command->biometricPhoto);
        $this->additionalDocumentService->uploadDocuments($application, $command->additionalDocuments);

        $application->setFatherName(FatherName::fromValue($command->fatherName));
        $application->setMotherName(MotherName::fromValue($command->motherName));
        $application->setFriendPhone(FriendPhone::fromValue($command->friendPhone));
        $application->setHomeAddress(HomeAddress::fromValue($command->homeAddress));

        // dd($application);
        $this->applicationRepository->save($application);
        $this->eventBus->publish(...$application->pullDomainEvents());
    }
}
