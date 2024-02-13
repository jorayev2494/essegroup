<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface SchoolAttestatServiceInterface
{
    public function upload(SchoolAttestateableInterface $logoable, ?UploadedFile $uploadedFile): void;

    public function update(SchoolAttestateableInterface $logoable, ?UploadedFile $uploadedFile): void;

    public function delete(SchoolAttestateableInterface $logoable): void;
}
