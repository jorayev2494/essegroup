<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Traits\Files;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\TranscriptTranslation;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationInterface;

trait TranscriptTranslationTrait
{
    #[ORM\OneToOne(targetEntity: TranscriptTranslation::class, inversedBy: 'student', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'transcript_translation_uuid', referencedColumnName: 'uuid', nullable: false)]
    private TranscriptTranslation $transcriptTranslation;

    #[\Override]
    public function getTranscriptTranslationClassName(): string
    {
        return TranscriptTranslation::class;
    }

    #[\Override]
    public function getTranscriptTranslation(): TranscriptTranslation
    {
        return $this->transcriptTranslation;
    }

    #[\Override]
    public function changeTranscriptTranslation(TranscriptTranslationInterface $transcriptTranslation): void
    {
        $this->transcriptTranslation = $transcriptTranslation;
    }

    #[\Override]
    public function deleteTranscriptTranslation(): void
    {
        // TODO: Implement deleteTranscriptTranslation() method.
    }
}
