<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentInterface;
use Project\Shared\Domain\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_additional_documents')]
#[ORM\HasLifecycleCallbacks]
class AdditionalDocument extends File implements AdditionalDocumentInterface
{
    #[\Override]
    public static function path(): string
    {
        return 'admin/domain/university/application/additional_documents';
    }

    #[ORM\Column(type: Types::STRING)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Application::class, inversedBy: 'additionalDocuments')]
    #[ORM\JoinColumn(name: 'application_uuid', referencedColumnName: 'uuid')]
    private Application $application;

    public function setApplication(?Application $application)
    {
        $this->application = $application;
    }

    public function setDescription(string $description): void
    {
        $this->description ??= '';
        if ($this->description !== $description) {
            $this->description = $description;
        }
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            ['description' => $this->description]
        );
    }
}
