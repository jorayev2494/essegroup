<?php

declare(strict_types=1);

namespace Project\Domains\Student\Profile\Application\Profile\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $birthday,
        public string $passportNumber,
        public string $passportDateOfIssue,
        public string $passportDateOfExpiry,
        public string $email,
        public string $phone,
        public string $nationalityUuid,
        public string $countryOfResidenceUuid,
        public string $highSchoolName,
        public string $highSchoolCountryUuid,
        public string $highSchoolGradeAverage,
        public ?UploadedFile $passport,
        public ?UploadedFile $passportTranslation,
        public ?UploadedFile $schoolAttestat,
        public ?UploadedFile $schoolAttestatTranslation,
        public ?UploadedFile $transcript,
        public ?UploadedFile $transcriptTranslation,
        public ?UploadedFile $equivalenceDocument,
        public ?UploadedFile $biometricPhoto,
        public array $additionalDocuments,
        public ?UploadedFile $avatar,
        public ?string $companyUuid,
        public ?string $fatherName,
        public ?string $motherName,
        public ?string $friendPhone,
        public ?string $homeAddress,
        public ?string $gender,
        public ?string $maritalType
    ) { }
}
