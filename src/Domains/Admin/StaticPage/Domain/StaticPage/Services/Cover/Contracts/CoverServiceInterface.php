<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface CoverServiceInterface
{
    public function upload(CoverableInterface $coverable, ?UploadedFile $uploadedFile): void;

    public function update(CoverableInterface $coverable, ?UploadedFile $uploadedFile): void;

    public function delete(CoverableInterface $coverable): void;
}
