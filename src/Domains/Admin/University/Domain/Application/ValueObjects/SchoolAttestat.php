<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\Contracts\SchoolAttestatInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table('university_application_school_attestats')]
#[ORM\HasLifecycleCallbacks]
class SchoolAttestat extends File implements SchoolAttestatInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/school_attestats';
    }

    #[ORM\OneToOne(targetEntity: Application::class, mappedBy: 'schoolAttestat')]
    private Application $application;
}
