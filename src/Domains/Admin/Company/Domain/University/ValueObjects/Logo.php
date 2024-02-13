<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\University\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table('company_university_logos')]
#[ORM\HasLifecycleCallbacks]
class Logo extends File implements LogoInterface
{

    #[ORM\OneToOne(targetEntity: University::class, mappedBy: 'logo')]
    private University $university;

    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/avatars';
    }
}
