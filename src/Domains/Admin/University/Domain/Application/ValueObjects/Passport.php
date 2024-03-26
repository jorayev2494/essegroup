<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\Contracts\PassportInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_passports')]
#[ORM\HasLifecycleCallbacks]
class Passport extends File implements PassportInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/passports';
    }

    #[ORM\OneToOne(targetEntity: Application::class, mappedBy: 'passport')]
    private Application $application;
}
