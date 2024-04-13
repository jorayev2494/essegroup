<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\TranscriptTranslation\Contracts;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\TranscriptTranslation;

interface TranscriptTranslationableInterface
{
    public function getTranscriptTranslationClassName(): string;

    public function getTranscriptTranslation(): TranscriptTranslation;

    public function changeTranscriptTranslation(TranscriptTranslationInterface $transcriptTranslation): void;

    public function deleteTranscriptTranslation(): void;
}
