<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\TranscriptTranslation;

interface TranscriptTranslationableInterface
{
    public function getTranscriptTranslationClassName(): string;

    public function getTranscriptTranslation(): TranscriptTranslation;

    public function changeTranscriptTranslation(TranscriptTranslationInterface $transcriptTranslation): void;

    public function deleteTranscriptTranslation(): void;
}
