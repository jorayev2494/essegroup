<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\University;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Translatable;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\University\ValueObjects\Logo;
use Project\Domains\Admin\Company\Domain\University\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\University\ValueObjects\Slug;
use Project\Domains\Admin\Company\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\University\Types\NameType;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\University\Types\SlugType;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\University\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table('company_universities')]
#[ORM\HasLifecycleCallbacks]
class University extends AggregateRoot implements TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: SlugType::NAME,  unique: true)]
    private Slug $slug;

    #[ORM\OneToOne(targetEntity: Logo::class, inversedBy: 'university', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'avatar_uuid', referencedColumnName: 'uuid')]
    private Logo $logo;

    #[ORM\Column(type: NameType::NAME, nullable: true)]
    #[Translatable]
    private Name $name;

    #[ORM\Column(name: 'company_uuid', type: Types::STRING)]
    private string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'universities')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid')]
    private Company $company;

    #[ORM\OneToMany(targetEntity: UniversityTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    public function __construct(Uuid $uuid, Slug $slug)
    {
        $this->uuid = $uuid;
        $this->slug = $slug;
        $this->translations = new ArrayCollection();
    }

    public static function fromPrimitives(string $uuid, string $slug): self
    {
        return new self(
            Uuid::fromValue($uuid),
            Slug::fromValue($slug)
        );
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    #[ORM\PrePersist]
    public function prePersist(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'slug' => $this->slug->value,
            // 'avatar' => $this->uuid->value,
            // 'cover' => $this->uuid->value,
            'name' => $this->name->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
