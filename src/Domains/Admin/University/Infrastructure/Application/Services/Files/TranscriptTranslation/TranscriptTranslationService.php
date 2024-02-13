<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\TranscriptTranslation;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationServiceInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class TranscriptTranslationService implements TranscriptTranslationServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(TranscriptTranslationableInterface $transcriptTranslationable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var TranscriptTranslation $transcriptTranslation */
        $transcriptTranslation = $this->fileSystem->upload($transcriptTranslationable->getTranscriptTranslationClassName(), $uploadedFile);
        $transcriptTranslationable->changeTranscriptTranslation($transcriptTranslation);
    }

    public function update(TranscriptTranslationableInterface $transcriptTranslationable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($transcriptTranslationable);
            $this->upload($transcriptTranslationable, $uploadedFile);
        }
    }

    public function delete(TranscriptTranslationableInterface $transcriptTranslationable): void
    {
        $this->fileSystem->delete($transcriptTranslationable->getTranscriptTranslation());
        $transcriptTranslationable->deleteTranscriptTranslation();
    }
}
