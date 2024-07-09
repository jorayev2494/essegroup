<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts;

use Project\Domains\Admin\Student\Domain\Student\Student;

interface AdditionalDocumentInterface
{
    public function setStudent(?Student $student): void;

    public function setDescription(string $description): void;

    public function getDescription(): ?string;
}
