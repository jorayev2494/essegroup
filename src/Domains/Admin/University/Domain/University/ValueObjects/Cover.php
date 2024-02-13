<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table('university_covers')]
#[ORM\HasLifecycleCallbacks]
class Cover extends File implements CoverInterface
{

    #[ORM\OneToOne(targetEntity: University::class, mappedBy: 'cover')]
    private University $university;

    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/covers';
    }
}
