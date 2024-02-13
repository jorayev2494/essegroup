<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Commands\Create;

use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\StatusEnum;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Email;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Phone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\Contracts\BiometricPhotoServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\Contracts\PassportServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts\PassportTranslationServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\Contracts\SchoolAttestatServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts\TranscriptServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\TranscriptService;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $applicationRepository,
        private PassportServiceInterface $passportService,
        private PassportTranslationServiceInterface $passportTranslationService,
        private SchoolAttestatServiceInterface $schoolAttestatService,
        private SchoolAttestatTranslationServiceInterface $schoolAttestatTranslationService,
        private TranscriptServiceInterface $transcriptService,
        private TranscriptTranslationServiceInterface $transcriptTranslationService,
        private EquivalenceDocumentServiceInterface $equivalenceDocumentService,
        private BiometricPhotoServiceInterface $biometricPhotoService,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $application = Application::create(
            Uuid::fromValue($command->uuid),
            Email::fromValue($command->email),
            Phone::fromValue($command->phone)
        );

        $this->passportService->upload($application, $command->passport);
        $this->passportTranslationService->upload($application, $command->passportTranslation);
        $this->schoolAttestatService->upload($application, $command->schoolAttestat);
        $this->schoolAttestatTranslationService->upload($application, $command->schoolAttestatTranslation);
        $this->transcriptService->upload($application, $command->transcript);
        $this->transcriptTranslationService->upload($application, $command->transcriptTranslation);
        $this->equivalenceDocumentService->upload($application, $command->equivalenceDocument);
        $this->biometricPhotoService->upload($application, $command->biometricPhoto);

        $this->applicationRepository->save($application);
    }
}
