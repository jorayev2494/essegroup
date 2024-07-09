<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Commands\Update;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\Country\Domain\Country\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\Uuid as CountryUuid;
use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid as LanguageUuid;
use Project\Domains\Admin\Student\Domain\Student\Exceptions\StudentNotFountExceptionDomainException;
use Project\Domains\Admin\Student\Domain\Student\Services\Avatar\Contracts\AvatarServiceInterface;
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
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use DateTimeImmutable;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $repository,
        private CompanyRepositoryInterface $companyRepository,
        private CountryRepositoryInterface $countryRepository,
        private PassportServiceInterface $passportService,
        private LanguageRepositoryInterface $languageRepository,
        private PassportTranslationServiceInterface $passportTranslationService,
        private SchoolAttestatServiceInterface $schoolAttestatService,
        private SchoolAttestatTranslationServiceInterface $schoolAttestatTranslationService,
        private TranscriptServiceInterface $transcriptService,
        private TranscriptTranslationServiceInterface $transcriptTranslationService,
        private EquivalenceDocumentServiceInterface $equivalenceDocumentService,
        private BiometricPhotoServiceInterface $biometricPhotoService,
        private AdditionalDocumentServiceInterface $additionalDocumentService,
        private AvatarServiceInterface $avatarService
    ) {

    }

    public function __invoke(Command $command): void
    {
        $student = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $student ?? throw new StudentNotFountExceptionDomainException();

        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));
        $nationality = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->nationalityUuid));
        $countryOfResidence = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->countryOfResidenceUuid));
        $highSchoolCountry = $this->countryRepository->findByUuid(CountryUuid::fromValue($command->highSchoolCountryUuid));
        $communicationLanguage = $this->languageRepository->findByUuid(LanguageUuid::fromValue($command->communicationLanguageUuid));

        $student->getFullName()
            ->changeFirstName(FirstName::fromValue($command->firstName))
            ->changeLastName(LastName::fromValue($command->lastName));

        $student->getParentsName()
            ->changeFatherName(FatherName::fromValue($command->fatherName))
            ->changeMotherName(MotherName::fromValue($command->motherName));
        $student->setCommunicationLanguage($communicationLanguage);

        $student->changeBirthday(new DateTimeImmutable($command->birthday));

        $student->getPassportInfo()
            ->changeNumber(PassportNumber::fromValue($command->passportNumber))
            ->changeDateOfIssue(new DateTimeImmutable($command->passportDateOfIssue))
            ->changeDateOfExpiry(new DateTimeImmutable($command->passportDateOfExpiry));

        $student->changeEmail(Email::fromValue($command->email));
        $student->changePhone(Phone::fromValue($command->phone));

        $student->changeCompany($company);
        $student->changeNationality($nationality);
        $student->changeCountryOfResidence($countryOfResidence);

        $student->changeHighSchool(
            HighSchool::make(
                HighSchoolName::fromValue($command->highSchoolName),
                GradeAverage::fromValue($command->highSchoolGradeAverage)
            )
        );

        $student->changeHighSchoolCountry($highSchoolCountry);

        $student->changeFriendPhone(FriendPhone::fromValue($command->friendPhone));
        $student->changeHomeAddress(HomeAddress::fromValue($command->homeAddress));

        $student->changeGender(Gender::from($command->gender));
        $student->changeMaritalType(MaritalType::from($command->maritalType));
        // dd($student);
        $this->avatarService->update($student, $command->avatar);
        $this->passportService->update($student, $command->passport);
        $this->passportTranslationService->update($student, $command->passportTranslation);
        $this->schoolAttestatService->update($student, $command->schoolAttestat);
        $this->schoolAttestatTranslationService->update($student, $command->schoolAttestatTranslation);
        $this->transcriptService->update($student, $command->transcript);
        $this->transcriptTranslationService->update($student, $command->transcriptTranslation);
        $this->equivalenceDocumentService->update($student, $command->equivalenceDocument);
        $this->biometricPhotoService->update($student, $command->biometricPhoto);
        $this->additionalDocumentService->uploadDocuments($student, $command->additionalDocuments);

        $this->repository->save($student);
    }
}
