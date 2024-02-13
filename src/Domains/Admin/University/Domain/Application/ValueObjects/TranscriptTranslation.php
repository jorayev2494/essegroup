<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table('university_application_transcript_translations')]
#[ORM\HasLifecycleCallbacks]
class TranscriptTranslation extends File implements TranscriptTranslationInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/transcript_translations';
    }

    #[ORM\OneToOne(targetEntity: Application::class, mappedBy: 'transcriptTranslation')]
    private Application $application;
}
