<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\Contracts;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\EquivalenceDocument;

interface EquivalenceDocumentableInterface
{
    public function getEquivalenceDocumentClassName(): string;

    public function getEquivalenceDocument(): EquivalenceDocument;

    public function changeEquivalenceDocument(EquivalenceDocumentInterface $equivalenceDocument): void;

    public function deleteEquivalenceDocument(): void;
}
