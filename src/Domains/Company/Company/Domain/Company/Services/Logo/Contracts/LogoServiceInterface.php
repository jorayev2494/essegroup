<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Domain\Company\Services\Logo\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface LogoServiceInterface
{
    public function upload(LogoableInterface $logoable, ?UploadedFile $uploadedFile): void;

    public function update(LogoableInterface $logoable, ?UploadedFile $uploadedFile): void;

    public function delete(LogoableInterface $logoable): void;
}