<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'faculty_logos')]
#[ORM\HasLifecycleCallbacks]
class Logo extends File implements LogoInterface
{

    public const int WIDTH = 75;

    public const int HEIGHT = 75;

    #[\Override]
    public static function path(): string
    {
        return '/admin/domain/university/faculty/logos';
    }

    #[ORM\OneToOne(targetEntity: Faculty::class, mappedBy: 'logo')]
    private Faculty $faculty;
}
