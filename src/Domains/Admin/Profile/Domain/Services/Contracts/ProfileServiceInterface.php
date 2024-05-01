<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Domain\Services\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ProfileServiceInterface
{
    public function show(): array;

    public function update(string $firstName, string $lastName, string $email, ?UploadedFile $avatar): void;
}
