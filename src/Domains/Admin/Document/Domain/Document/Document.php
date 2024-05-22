<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileableInterface;
use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileInterface;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\File;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Title;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\TypeEnum;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Uuid;
use Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine\Types\TitleType;
use Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine\Types\TypeType;
use Project\Domains\Admin\Document\Infrastructure\Document\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'document_documents')]
#[ORM\HasLifecycleCallbacks]
class Document implements EntityUuid, TranslatableInterface, FileableInterface, ArrayableInterface
{
    use TranslatableTrait,
        ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: TitleType::NAME, nullable: true)]
    private Title $title;

    #[ORM\Column(type: TypeType::NAME, length: 10)]
    private TypeEnum $type;

    #[ORM\Column(name: 'file_uuid', type: Types::GUID)]
    private string $fileUuid;

    #[ORM\OneToOne(targetEntity: File::class, inversedBy: 'document', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'file_uuid', referencedColumnName: 'uuid')]
    private File $file;

    /**
     * @var DocumentTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: DocumentTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    private function __construct(Uuid $uuid, TypeEnum $type, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->title = Title::fromValue(null);
        // $this->file = $file;
        $this->type = $type;
        $this->translations = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function create(Uuid $uuid, TypeEnum $type, bool $isActive): self
    {
        return new self($uuid, $type, $isActive);
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return DocumentTranslation::class;
    }

    public function getFile(): FileInterface
    {
        return $this->file;
    }

    public function changeType(TypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function changeIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function changeFile(FileInterface $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function deleteFile(): static
    {
        return $this;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'title' => $this->title->value,
            'type' => $this->type->value,
            'file' => $this->file->toArray(),
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
