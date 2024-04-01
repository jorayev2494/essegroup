<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Faculty\Events\FacultyWasDeletedDomainEvent;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Description;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Logo;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\DescriptionType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\NameType;
use Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\Faculty\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoableInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'faculty_faculties')]
#[ORM\HasLifecycleCallbacks]
class Faculty extends AggregateRoot implements EntityUuid, TranslatableInterface, LogoableInterface
{
    use ActivableTrait,
        CreatedAtAndUpdatedAtTrait,
        TranslatableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\OneToOne(targetEntity: Logo::class, inversedBy: 'faculty', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'logo_uuid', referencedColumnName: 'uuid', unique: true, nullable: false)]
    private ?Logo $logo;

    #[ORM\Column(type: NameType::NAME, nullable: true)]
    private Name $name;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\OneToMany(targetEntity: FacultyTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    private function __construct(Uuid $uuid, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->name = Name::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->logo = null;
        $this->isActive = $isActive;
        $this->translations = new ArrayCollection();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): ?Name
    {
        return $this->name;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?Description
    {
        return $this->description;
    }

    public function setDescription(Description $description): void
    {
        $this->description = $description;
    }

    public function getLogo(): ?LogoInterface
    {
        return $this->logo;
    }

    public function setLogo(?LogoInterface $logo): static
    {
        if ($this->logo !== $logo) {
            $this->logo = $logo;
        }

        return $this;
    }

    public function translationDomainEvent(AbstractTranslation $translation, TranslationDomainEventTypeEnum $type): void
    {
//        $domainEvent = match ($type) {
//            TranslationDomainEventTypeEnum::ADDED => new UniversityTranslationWasAddedDomainEvent(
//                $this->uuid->value,
//                $translation->getLocale(),
//                $translation->getField(),
//                $translation->getContent()
//            ),
//            TranslationDomainEventTypeEnum::CHANGED => new UniversityTranslationWasChangedDomainEvent(
//                $this->uuid->value,
//                $translation->getLocale(),
//                $translation->getField(),
//                $translation->getContent()
//            ),
//            TranslationDomainEventTypeEnum::DELETED => new UniversityTranslationWasDeletedDomainEvent(
//                $this->uuid->value,
//                $translation->getLocale(),
//                $translation->getField()
//            ),
//        };
//
//        $this->record($domainEvent);
    }

    public static function create(Uuid $uuid, bool $isActive): self
    {
        return new self($uuid, $isActive);
    }

    public function delete(): void
    {
        $this->record(new FacultyWasDeletedDomainEvent($this->uuid->value));
    }

    #[\Override]
    public function getLogoClassName(): string
    {
        return Logo::class;
    }

    #[\Override]
    public function changeLogo(?LogoInterface $logo): static
    {
        if ($this->logo !== $logo) {
            $this->logo = $logo;
        }

        return $this;
    }

    public function changeIsActive(bool $value): void
    {
        if ($this->isActive !== $value) {
            $this->isActive = $value;
        }
    }

    #[\Override]
    public function deleteLogo(): static
    {
        // if ($this->logo !== null) {
        //     $this->logo = null;
        // }

        return $this;
    }

    public function isEquals(self $other): bool
    {
        return $this->uuid === $other->uuid;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->uuid !== $other->uuid;
    }

    public function getTranslationClass(): string
    {
        return FacultyTranslation::class;
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'name' => $this->name->value,
            'description' => $this->description->value,
            'logo' => $this->logo?->toArray(),
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
