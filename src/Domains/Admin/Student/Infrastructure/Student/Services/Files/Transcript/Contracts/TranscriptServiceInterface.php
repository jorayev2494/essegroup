<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Transcript\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface TranscriptServiceInterface
{
    public function upload(TranscriptableInterface $transcriptable, ?UploadedFile $uploadedFile): void;

    public function update(TranscriptableInterface $transcriptable, ?UploadedFile $uploadedFile): void;

    public function delete(TranscriptableInterface $transcriptable): void;
}
