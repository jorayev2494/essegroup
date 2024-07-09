<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface AvatarServiceInterface
{
    public function upload(AvatarableInterface $avatarable, ?UploadedFile $uploadedFile): void;

    public function update(AvatarableInterface $avatarable, ?UploadedFile $uploadedFile): void;

    public function delete(AvatarableInterface $avatarable): void;
}
