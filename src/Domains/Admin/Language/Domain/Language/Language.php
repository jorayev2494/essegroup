<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Domain\Language;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Value;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Language\Infrastructure\Language\Repositories\Doctrine\Types\ValueType;
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

    /**
     * @var LanguageTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: LanguageTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    private function __construct(Uuid $uuid, bool $isActive)
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
        return LanguageTranslation::class;
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
