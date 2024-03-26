<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_school_attestat_translations')]
#[ORM\HasLifecycleCallbacks]
class SchoolAttestatTranslation extends File implements SchoolAttestatTranslationInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/school_attestat_translations';
    }

    #[ORM\OneToOne(targetEntity: Application::class, mappedBy: 'schoolAttestatTranslation')]
    private Application $application;
}
