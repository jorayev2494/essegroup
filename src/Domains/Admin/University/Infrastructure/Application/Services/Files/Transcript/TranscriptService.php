<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript;

use Project\Domains\Admin\University\Domain\University\ValueObjects\Logo;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts\TranscriptableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts\TranscriptServiceInterface;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class TranscriptService implements TranscriptServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem,
    )
    {

    }

    public function upload(TranscriptableInterface $transcriptable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        $transcript = $this->fileSystem->upload($transcriptable->getTranscriptClassName(), $uploadedFile);
        $transcriptable->changeTranscript($transcript);
    }

    public function update(TranscriptableInterface $transcriptable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            $this->delete($transcriptable);
            $this->upload($transcriptable, $uploadedFile);
        }
    }

    public function delete(TranscriptableInterface $transcriptable): void
    {
        $this->fileSystem->delete($transcriptable->getTranscript());
        $transcriptable->deleteTranscript();
    }
}
