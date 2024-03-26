<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_equivalence_documents')]
#[ORM\HasLifecycleCallbacks]
class EquivalenceDocument extends File implements EquivalenceDocumentInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/equivalence_documents';
    }

    #[ORM\OneToOne(targetEntity: Application::class, mappedBy: 'equivalenceDocument')]
    private Application $application;
}
