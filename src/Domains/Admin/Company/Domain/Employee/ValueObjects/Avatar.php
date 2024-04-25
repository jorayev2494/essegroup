<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Employee\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Company\Domain\Employee\Employee;
use Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\Contracts\AvatarInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'company_employee_avatars')]
#[ORM\HasLifecycleCallbacks]
class Avatar extends File implements AvatarInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/company/employee/avatars';
    }

    #[ORM\OneToOne(targetEntity: Employee::class, mappedBy: 'avatar')]
    private ?Employee $employee;
}
