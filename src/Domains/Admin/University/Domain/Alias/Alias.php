<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Alias;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Value;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Alias\Repositories\Doctrine\Types\ValueType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'university_aliases')]
#[ORM\HasLifecycleCallbacks]
class Alias implements EntityUuid, ArrayableInterface, TranslatableInterface
{
    use TranslatableTrait, ActivableTrait, CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME, nullable: true)]
    private Value $value;

    /**
     * @var AliasTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: AliasTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    public function __construct(Uuid $uuid, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->value = Value::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function create(Uuid $uuid, bool $isActive): self
    {
        return new self($uuid, $isActive);
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    public function setValue(Value $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return AliasTranslation::class;
    }

    public function translationDomainEvent(AbstractTranslation $translation, TranslationDomainEventTypeEnum $type): void
    {
        // $domainEvent = match ($type) {
        //     TranslationDomainEventTypeEnum::ADDED => new UniversityTranslationWasAddedDomainEvent(
        //         $this->uuid->value,
        //         $translation->getLocale(),
        //         $translation->getField(),
        //         $translation->getContent()
        //     ),
        //     TranslationDomainEventTypeEnum::CHANGED => new UniversityTranslationWasChangedDomainEvent(
        //         $this->uuid->value,
        //         $translation->getLocale(),
        //         $translation->getField(),
        //         $translation->getContent()
        //     ),
        //     TranslationDomainEventTypeEnum::DELETED => new UniversityTranslationWasDeletedDomainEvent(
        //         $this->uuid->value,
        //         $translation->getLocale(),
        //         $translation->getField()
        //     ),
        // };
        //
        // $this->record($domainEvent);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
