<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueBackgroundColor;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueTextColor;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueDescription;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueValue;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueBackgroundColorType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueTextColorType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueDescriptionType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueUuidType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\StatusValueValueType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_status_values')]
#[ORM\HasLifecycleCallbacks]
class StatusValue implements EntityUuid, TranslatableInterface, ArrayableInterface
{
    use TranslatableTrait,
        ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: StatusValueUuidType::NAME)]
    private StatusValueUuid $uuid;

    #[ORM\Column(type: StatusValueValueType::NAME, length: 20, nullable: true)]
    private StatusValueValue $value;

    #[ORM\Column(type: StatusValueTextColorType::NAME, length: 10)]
    private StatusValueTextColor $textColor;

    #[ORM\Column(type: StatusValueBackgroundColorType::NAME, length: 10)]
    private StatusValueBackgroundColor $backgroundColor;

    #[ORM\Column(name: 'is_first', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isFirst;

    #[ORM\Column(type: StatusValueDescriptionType::NAME, nullable: true)]
    private StatusValueDescription $description;

    #[ORM\OneToMany(targetEntity: StatusValueTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'is_required_note')]
    private bool $isRequiredNote;

    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'statusValue')]
    private Collection $statuses;

    private function __construct(
        StatusValueUuid $uuid,
        StatusValueTextColor $textColor,
        StatusValueBackgroundColor $backgroundColor,
        bool $isRequiredNote,
        bool $isFirst
    ) {
        $this->uuid = $uuid;
        $this->textColor = $textColor;
        $this->backgroundColor = $backgroundColor;
        $this->value = StatusValueValue::fromValue(null);
        $this->description = StatusValueDescription::fromValue(null);
        $this->isRequiredNote = $isRequiredNote;
        $this->statuses = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->isFirst = $isFirst;
        $this->isActive = true;
    }

    public static function fromPrimitives(string $uuid, string $textColor, string $backgroundColor, bool $isRequiredNote, bool $isFirst): self
    {
        return new self(
            StatusValueUuid::fromValue($uuid),
            StatusValueTextColor::fromValue($textColor),
            StatusValueBackgroundColor::fromValue($backgroundColor),
            $isRequiredNote,
            $isFirst
        );
    }

    public static function create(StatusValueUuid $uuid, StatusValueTextColor $textColor, StatusValueBackgroundColor $backgroundColor, bool $isRequiredNote, bool $isFirst): self
    {
        return new self($uuid, $textColor, $backgroundColor, $isRequiredNote, $isFirst);
    }

    public function getUuid(): StatusValueUuid
    {
        return $this->uuid;
    }

    public function getValue(): StatusValueValue
    {
        return $this->value;
    }

    public function setValue(StatusValueValue $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setDescription(StatusValueDescription $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setTextColor(StatusValueTextColor $textColor): self
    {
        $this->textColor = $textColor;

        return $this;
    }

    public function setBackgroundColor(StatusValueBackgroundColor $backgroundColor): self
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function setIsRequiredNote(bool $isRequiredNote): self
    {
        $this->isRequiredNote = $isRequiredNote;

        return $this;
    }

    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function setIsFirst(bool $isFirst): self
    {
        $this->isFirst = $isFirst;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return StatusValueTranslation::class;
    }

    public function getIsRequiredNote(): bool
    {
        return $this->isRequiredNote;
    }

    public function isEqual(self $other): bool
    {
        return $this->uuid->value === $other->getUuid()->value;
    }

    public function isNotEqual(self $other): bool
    {
        return $this->uuid->value !== $other->getUuid()->value;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'text_color' => $this->textColor->value,
            'background_color' => $this->backgroundColor->value,
            'description' => $this->description->value,
            'is_required_note' => $this->isRequiredNote,
            'is_first' => $this->isFirst,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
