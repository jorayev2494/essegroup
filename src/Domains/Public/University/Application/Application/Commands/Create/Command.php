<?php

declare(strict_types=1);

namespace Project\Domains\Public\University\Application\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public string $email,
        public string $phone,
        public UploadedFile $passport,
        public UploadedFile $passportTranslation,
        public UploadedFile $schoolAttestat,
        public UploadedFile $schoolAttestatTranslation,
        public UploadedFile $transcript,
        public UploadedFile $transcriptTranslation,
        public UploadedFile $equivalenceDocument,
        public UploadedFile $biometricPhoto,
    )
    {

    }
}
