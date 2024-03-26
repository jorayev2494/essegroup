<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Status;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Status\ValueObjects\Note;
use Project\Domains\Admin\Company\Domain\Status\ValueObjects\Value;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Status\Types\NoteType;
use Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\Status\Types\ValueType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'company_statuses')]
#[ORM\HasLifecycleCallbacks]
class Status implements ArrayableInterface
{
    use CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: ValueType::NAME)]
    private Value $value;

    #[ORM\Column(type: NoteType::NAME, nullable: true)]
    private Note $note;

    #[ORM\Column(name: 'company_uuid', type: Types::STRING)]
    private string $companyUuid;

    // #[ORM\OneToOne(targetEntity: Company::class, inversedBy: 'company')]
    // #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', nullable: false)]
    // private Company $company;

    // #[ORM\OneToOne(targetEntity: Company::class, inversedBy: 'company')]
    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'companies')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Company $company;

    private function __construct(Value $value, Note $note)
    {
        $this->value = $value;
        $this->note = $note;
    }

    public static function fromPrimitives(string $value, ?string $note = null): self
    {
        return new self(
            Value::fromValue($value),
            Note::fromValue($note),
        );
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value->value,
            'note' => $this->note->value,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
