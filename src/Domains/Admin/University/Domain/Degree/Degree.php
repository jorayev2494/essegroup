<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Degree;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Value;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Degree\Repositories\Doctrine\Types\ValueType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'university_degrees')]
#[ORM\HasLifecycleCallbacks]
class Degree implements EntityUuid, TranslatableInterface, ArrayableInterface
{
    use CreatedAtAndUpdatedAtTrait,
        TranslatableTrait,
        ActivableTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME, nullable: true)]
    private Value $value;

    #[ORM\Column(name: 'company_uuid', nullable: true)]
    private ?string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'departments')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?Company $company;

    #[ORM\ManyToMany(targetEntity: Department::class, mappedBy: 'degrees')]
    private Collection $departments;

    #[ORM\OneToMany(targetEntity: DegreeTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    private function __construct(Uuid $uuid, Company $company, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->company = $company;
        $this->isActive = $isActive;
        $this->value = Value::fromValue(null);
        $this->translations = new ArrayCollection();
    }

    public static function create(Uuid $uuid, Company $company, bool $isActive): self
    {
        return new self($uuid, $company, $isActive);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setCompanyUuid(string $companyUuid): self
    {
        $this->companyUuid = $companyUuid;

        return $this;
    }

    public function setValue(Value $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return DegreeTranslation::class;
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

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'company_uuid' => $this->companyUuid,
            'company' => $this->company->getUuid()->isNotNull() ? $this->company->toArray() : null,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
