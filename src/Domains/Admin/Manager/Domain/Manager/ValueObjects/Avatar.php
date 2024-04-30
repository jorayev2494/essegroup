<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\Contracts\AvatarInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'company_manager_avatars')]
#[ORM\HasLifecycleCallbacks]
class Avatar extends File implements AvatarInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/manager/manager/avatars';
    }

    #[ORM\OneToOne(targetEntity: Manager::class, mappedBy: 'avatar')]
    private ?Manager $manager;
}
