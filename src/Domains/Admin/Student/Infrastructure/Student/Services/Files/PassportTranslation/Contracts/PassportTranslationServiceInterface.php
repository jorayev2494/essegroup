<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\PassportTranslation\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PassportTranslationServiceInterface
{
    public function upload(PassportTranslationableInterface $PassportTranslationable, ?UploadedFile $uploadedFile): void;

    public function update(PassportTranslationableInterface $PassportTranslationable, ?UploadedFile $uploadedFile): void;

    public function delete(PassportTranslationableInterface $PassportTranslationable): void;
}
