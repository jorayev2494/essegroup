<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\Transcript;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Transcript\Contracts\TranscriptInterface;

trait TranscriptTrait
{
    #[ORM\ManyToOne(targetEntity: Transcript::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'transcript_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Transcript $transcript;

    #[\Override]
    public function getTranscriptClassName(): string
    {
        return Transcript::class;
    }

    #[\Override]
    public function getTranscript(): Transcript
    {
        return $this->transcript;
    }

    #[\Override]
    public function changeTranscript(TranscriptInterface $transcript): void
    {
        $this->transcript = $transcript;
    }

    #[\Override]
    public function deleteTranscript(): void
    {
        // TODO: Implement deleteTranscript() method.
    }
}
