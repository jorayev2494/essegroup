<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface SchoolAttestatTranslationServiceInterface
{
    public function upload(SchoolAttestatTranslationableInterface $schoolAttestatTranslationable, ?UploadedFile $uploadedFile): void;

    public function update(SchoolAttestatTranslationableInterface $schoolAttestatTranslationable, ?UploadedFile $uploadedFile): void;

    public function delete(SchoolAttestatTranslationableInterface $schoolAttestatTranslationable): void;
}
