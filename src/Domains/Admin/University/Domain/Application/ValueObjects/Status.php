<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\StatusEnum;
use Project\Domains\Admin\University\Domain\Application\StatusNoteTranslation;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusEnumType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusIdType;
use Project\Shared\Contracts\ArrayableInterface;
use DateTimeImmutable;
use Project\Shared\Domain\Contracts\EntityId;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\IdValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_statuses')]
#[ORM\HasLifecycleCallbacks]
class Status implements EntityId, ArrayableInterface, TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: StatusIdType::NAME)]
    private StatusId $id;

    #[ORM\Column(type: StatusEnumType::NAME, length: 20)]
    private StatusEnum $value;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note;

    #[ORM\ManyToOne(targetEntity: Application::class, inversedBy: 'statues')]
    #[ORM\JoinColumn(name: 'application_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Application $application;

    #[ORM\OneToMany(targetEntity: StatusNoteTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    private function __construct(StatusEnum $value)
    {
        $this->value = $value;
        $this->note = null;
        $this->translations = new ArrayCollection();
    }

    public static function fromPrimitives(string $value): self
    {
        return new self(StatusEnum::from($value));
    }

    public function getId(): IdValueObject
    {
        return $this->id;
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

    public function getValue(): StatusEnum
    {
        return $this->value;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function isEqualsValue(StatusEnum $value): bool
    {
        return $this->value->value === $value->value;
    }

    public function isEqualsNote(?string $note): bool
    {
        return $this->note === $note;
    }

    public function isNotEqualsValue(StatusEnum $value): bool
    {
        return $this->value->value !== $value->value;
    }

    public function isNotEqualsNote(?string $note): bool
    {
        return $this->note !== $note;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function getTranslationClass(): string
    {
        return StatusNoteTranslation::class;
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

    #[\Override]
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'note' => $this->note,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
