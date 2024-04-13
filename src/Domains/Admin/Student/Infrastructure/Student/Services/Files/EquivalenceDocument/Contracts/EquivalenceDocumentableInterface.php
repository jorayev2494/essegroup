<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\Contracts;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\EquivalenceDocument;

interface EquivalenceDocumentableInterface
{
    public function getEquivalenceDocumentClassName(): string;

    public function getEquivalenceDocument(): EquivalenceDocument;

    public function changeEquivalenceDocument(EquivalenceDocumentInterface $equivalenceDocument): void;

    public function deleteEquivalenceDocument(): void;
}
