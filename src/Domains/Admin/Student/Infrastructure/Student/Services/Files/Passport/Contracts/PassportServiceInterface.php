<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PassportServiceInterface
{
    public function upload(PassportableInterface $logoable, ?UploadedFile $uploadedFile): void;

    public function update(PassportableInterface $logoable, ?UploadedFile $uploadedFile): void;

    public function delete(PassportableInterface $logoable): void;
}
