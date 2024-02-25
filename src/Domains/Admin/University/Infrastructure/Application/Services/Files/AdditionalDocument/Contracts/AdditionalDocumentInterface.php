<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\Contracts;

interface AdditionalDocumentInterface
{
    public function setDescription(string $description): void;
}
