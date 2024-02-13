<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts\TranscriptInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table('university_application_transcripts')]
#[ORM\HasLifecycleCallbacks]
class Transcript extends File implements TranscriptInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/transcripts';
    }

    #[ORM\OneToOne(targetEntity: Application::class, mappedBy: 'transcript')]
    private Application $application;
}
