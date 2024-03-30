<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $fullName,
        public string $birthday,
        public string $passportNumber,
        public string $email,
        public string $phone,
        public string $universityUuid,
        public array $departmentUuids,
        public string $countryUuid,
        public UploadedFile $passport,
        public UploadedFile $passportTranslation,
        public UploadedFile $schoolAttestat,
        public UploadedFile $schoolAttestatTranslation,
        public UploadedFile $transcript,
        public UploadedFile $transcriptTranslation,
        public UploadedFile $equivalenceDocument,
        public UploadedFile $biometricPhoto,
        public array $additionalDocuments,
        public bool $isAgreedToShareData,
        public string $creatorRole,
        public string $companyUuid,
        public ?string $fatherName,
        public ?string $motherName,
        public ?string $friendPhone,
        public ?string $homeAddress,
    )
    {

    }
}
