<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts\LogoInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table('company_logos')]
#[ORM\HasLifecycleCallbacks]
class Logo extends File implements LogoInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/company/logos';
    }

    #[ORM\OneToOne(targetEntity: Company::class, mappedBy: 'logo', cascade: ['persist', 'remove'])]
    private Company $company;
}
