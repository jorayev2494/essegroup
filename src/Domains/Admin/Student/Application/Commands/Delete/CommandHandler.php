<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Commands\Delete;

use Project\Domains\Admin\Student\Domain\Student\Exceptions\StudentNotFountExceptionDomainException;
use Project\Domains\Admin\Student\Domain\Student\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
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

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StudentRepositoryInterface $repository,
        private PassportServiceInterface $passportService,
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

        $this->avatarService->delete($student);
        $this->passportService->delete($student);
        $this->passportTranslationService->delete($student);
        $this->schoolAttestatService->delete($student);
        $this->schoolAttestatTranslationService->delete($student);
        $this->transcriptService->delete($student);
        $this->transcriptTranslationService->delete($student);
        $this->equivalenceDocumentService->delete($student);
        $this->biometricPhotoService->delete($student);
        $this->additionalDocumentService->deleteDocuments($student);

        $this->repository->delete($student);
    }
}
