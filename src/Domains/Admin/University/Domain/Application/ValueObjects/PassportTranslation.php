<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts\PassportTranslationInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_passport_translations')]
#[ORM\HasLifecycleCallbacks]
class PassportTranslation extends File implements PassportTranslationInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/passport_translations';
    }

    #[ORM\OneToOne(targetEntity: Application::class, mappedBy: 'passportTranslation')]
    private Application $application;
}
