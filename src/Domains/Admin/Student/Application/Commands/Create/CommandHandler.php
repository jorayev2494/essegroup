<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Commands\Create;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid as CountryUuid;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid as LanguageUuid;
use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Student\Domain\Student\Services\Contracts\StudentServiceInterface;
use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Email;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables\FullName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables\HighSchool;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables\ParentsName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables\PassportInfo;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\Gender;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\MaritalType;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\FatherName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\FriendPhone;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\FirstName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\GradeAverage;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\HighSchoolName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\HomeAddress;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\LastName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\MotherName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\PassportNumber;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Password;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Phone;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentServiceInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts\BiometricPhotoServiceInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentServiceInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\Contracts\PassportServiceInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\PassportTranslation\Contracts\PassportTranslationServiceInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\Contracts\SchoolAttestatServiceInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationServiceInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Transcript\Contracts\TranscriptServiceInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationServiceInterface;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use DateTimeImmutable;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TokenGeneratorInterface $tokenGenerator,
        private StudentRepositoryInterface $studentRepository,
        private CompanyRepositoryInterface $companyRepository,
        private CountryRepositoryInterface $countryRepository,
        private LanguageRepositoryInterface $languageRepository,
        private StudentServiceInterface $service,
        private PassportServiceInterface $passportService,
        private PassportTranslationServiceInterface $passportTranslationService,
        private SchoolAttestatServiceInterface $schoolAttestatService,
        private SchoolAttestatTranslationServiceInterface $schoolAttestatTranslationService,
        private TranscriptServiceInterface $transcriptService,
        private TranscriptTranslationServiceInterface $transcriptTranslationService,
        private EquivalenceDocumentServiceInterface $equivalenceDocumentService,
        private BiometricPhotoServiceInterface $biometricPhotoService,
        private AdditionalDocumentServiceInterface $additionalDocumentService,
        private AvatarServiceInterface $avatarService,
        private EventBusInterface $eventBus
    ) {

    }

    public function __invoke(Command $command): void
    {
        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));
        $nationality = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->nationalityUuid));
        $countryOfResidence = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->countryOfResidenceUuid));
        $highSchoolCountry = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->highSchoolCountryUuid));
        $communicationLanguage = $command->communicationLanguageUuid ? $this->languageRepository->findByUuid(LanguageUuid::fromValue($command->communicationLanguageUuid)) : null;

        $student = Student::create(
            Uuid::fromValue($command->uuid),
            FullName::make(FirstName::fromValue($command->firstName), LastName::fromValue($command->lastName)),
            ParentsName::make(FatherName::fromValue($command->fatherName), MotherName::fromValue($command->motherName)),
            new DateTimeImmutable($command->birthday),
            PassportInfo::make(
                PassportNumber::fromValue($command->passportNumber)
            ),
            Email::fromValue($command->email),
            Phone::fromValue($command->phone),
            $company,
            $nationality,
            $countryOfResidence,
            $highSchoolCountry,
            Password::fromValue($this->tokenGenerator->generate(Password::LENGTH)),
            $command->creatorRole
        );

        $this->service->passportInfo($student, $command->passportDateOfIssue, $command->passportDateOfExpiry);
        $this->service->highSchool($student, $command->highSchoolName, $command->highSchoolGradeAverage);

        if ($command->creatorRole !== 'client') {
            $student->changeGender(Gender::from($command->gender));
            $student->changeMaritalType(MaritalType::from($command->maritalType));
        }

        $student->changeFriendPhone(FriendPhone::fromValue($command->friendPhone));
        $student->changeHomeAddress(HomeAddress::fromValue($command->homeAddress));
        $student->setCommunicationLanguage($communicationLanguage);

        $this->avatarService->upload($student, $command->avatar);
        $this->passportService->upload($student, $command->passport);
        $this->passportTranslationService->upload($student, $command->passportTranslation);
        $this->schoolAttestatService->upload($student, $command->schoolAttestat);
        $this->schoolAttestatTranslationService->upload($student, $command->schoolAttestatTranslation);
        $this->transcriptService->upload($student, $command->transcript);
        $this->transcriptTranslationService->upload($student, $command->transcriptTranslation);
        $this->equivalenceDocumentService->upload($student, $command->equivalenceDocument);
        $this->biometricPhotoService->upload($student, $command->biometricPhoto);
        $this->additionalDocumentService->uploadDocuments($student, $command->additionalDocuments);

        $this->studentRepository->save($student);
        $this->eventBus->publish(...$student->pullDomainEvents());
    }
}
