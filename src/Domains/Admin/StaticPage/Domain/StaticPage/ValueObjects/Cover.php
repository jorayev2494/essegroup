<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts\CoverInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPage;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'static_page_static_page_covers')]
#[ORM\HasLifecycleCallbacks]
class Cover extends File implements CoverInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/static_page/static_page/covers';
    }

    #[ORM\OneToOne(targetEntity: StaticPage::class, mappedBy: 'cover')]
    private StaticPage $staticPage;
}
