<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface TranscriptTranslationServiceInterface
{
    public function upload(TranscriptTranslationableInterface $transcriptTranslationable, ?UploadedFile $uploadedFile): void;

    public function update(TranscriptTranslationableInterface $transcriptTranslationable, ?UploadedFile $uploadedFile): void;

    public function delete(TranscriptTranslationableInterface $transcriptTranslationable): void;
}
