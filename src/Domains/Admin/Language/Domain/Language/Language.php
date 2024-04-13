<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Domain\Language;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\ISO;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Value;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Types\ISOType;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Types\ValueType;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'language_languages')]
#[ORM\HasLifecycleCallbacks]
class Language implements EntityUuid, TranslatableInterface, ArrayableInterface
{
    use TranslatableTrait, ActivableTrait, CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME, nullable: true)]
    private Value $value;

    #[ORM\Column(name: 'iso', type: ISOType::NAME, length: 3)]
    private ISO $iso;

    /**
     * @var LanguageTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: LanguageTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'language')]
    private Collection $applications;

    private function __construct(Uuid $uuid, ISO $iso, bool $isActive)
    {
        $this->uuid = $uuid;
        $this->iso = $iso;
        $this->value = Value::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->isActive = $isActive;
    }

    public static function create(Uuid $uuid, ISO $iso, bool $isActive): self
    {
        return new self($uuid, $iso, $isActive);
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

    public function setISO(ISO $iso): self
    {
        $this->iso = $iso;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return LanguageTranslation::class;
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
            'iso' => $this->iso->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
