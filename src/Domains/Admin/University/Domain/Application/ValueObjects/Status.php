<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\ValueObjects;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Language\Domain\Language\Language;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\StatusNoteTranslation;
use Project\Domains\Admin\University\Domain\Application\StatusValue;
use Project\Domains\Admin\University\Domain\Application\StatusValueTranslate;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusIdType;
use Project\Shared\Contracts\ArrayableInterface;
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

    #[ORM\Column(name: 'status_value_uuid')]
    private string $statusValueUuid;

    #[ORM\ManyToOne(targetEntity: StatusValue::class, inversedBy: 'statuses')]
    #[ORM\JoinColumn(name: 'status_value_uuid', referencedColumnName: 'uuid')]
    private StatusValue $statusValue;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note;

    #[ORM\Column(name: 'application_uuid', type: Types::STRING)]
    private string $applicationUuid;

    #[ORM\ManyToOne(targetEntity: Application::class, inversedBy: 'statues')]
    #[ORM\JoinColumn(name: 'application_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Application $application;

    #[ORM\OneToMany(targetEntity: StatusNoteTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    private function __construct(StatusValue $statusValue)
    {
        $this->statusValue = $statusValue;
        $this->note = null;
        $this->translations = new ArrayCollection();
    }

    public static function create(StatusValue $statusValue): self
    {
        return new self($statusValue);
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

    public function setApplication(Application $application): self
    {
        $this->application = $application;

        return $this;
    }

    public function getStatusValue(): StatusValue
    {
        return $this->statusValue;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

     public function isEqualsValue(StatusValue $statusValue): bool
     {
         return $this->statusValue->isEqual($statusValue);
     }

    public function isNotEqualsValue(StatusValue $statusValue): bool
    {
        return $this->statusValue->isNotEqual($statusValue);
    }

    public function isEqualsNote(?string $note): bool
    {
        return $this->note === $note;
    }

    // public function isNotEqualsValue(StatusEnum $value): bool
    // {
    //     return $this->value->value !== $value->value;
    // }

    public function isNotEqualsNote(?string $note): bool
    {
        return $this->note !== $note;
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
            'note' => $this->note,
            'value' => StatusValueTranslate::execute($this->statusValue)?->toArray(),
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
