<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Domain\Currency;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Code;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Description;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Symbol;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Value;
use Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\CodeType;
use Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\DescriptionType;
use Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\SymbolType;
use Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine\Types\ValueType;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'currency_currencies')]
#[ORM\HasLifecycleCallbacks]
class Currency implements EntityUuid, ArrayableInterface
{
    use ActivableTrait, CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: ValueType::NAME)]
    private Value $value;

    #[ORM\Column(type: CodeType::NAME, length: 5, unique: true)]
    private Code $code;

    #[ORM\Column(type: SymbolType::NAME, length: 5, unique: true)]
    private Symbol $symbol;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\Column(name: 'is_main')]
    private bool $isMain;

    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'priceCurrency')]
    private Collection $departments;

    private function __construct(
        Uuid $uuid,
        Value $value,
        Code $code,
        Symbol $symbol,
        Description $description,
        bool $isMain
    )
    {
        $this->uuid = $uuid;
        $this->value = $value;
        $this->code = $code;
        $this->symbol = $symbol;
        $this->description = $description;
        $this->isMain = $isMain;
        $this->isActive = true;
        $this->departments = new ArrayCollection();
    }

    public static function create(Uuid $uuid, Value $value, Code $code, Symbol $symbol, Description $description, bool $isMain): self
    {
        return new self($uuid, $value, $code, $symbol, $description, $isMain);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function isEquals(self $other): bool
    {
        return $this->uuid->value === $other->getUuid()->value;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->uuid->value !== $other->getUuid()->value;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'value' => $this->value->value,
            'code' => $this->code->value,
            'symbol' => $this->symbol->value,
            'description' => $this->description->value,
        ];
    }
}
