<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Transcript\Contracts;

use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\Transcript;

interface TranscriptableInterface
{
    public function getTranscriptClassName(): string;

    public function getTranscript(): Transcript;

    public function changeTranscript(TranscriptInterface $transcript): void;

    public function deleteTranscript(): void;
}
