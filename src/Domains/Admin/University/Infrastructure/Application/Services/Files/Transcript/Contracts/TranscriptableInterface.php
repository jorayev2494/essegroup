<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\Transcript;

interface TranscriptableInterface
{
    public function getTranscriptClassName(): string;

    public function getTranscript(): Transcript;

    public function changeTranscript(TranscriptInterface $transcript): void;

    public function deleteTranscript(): void;
}
