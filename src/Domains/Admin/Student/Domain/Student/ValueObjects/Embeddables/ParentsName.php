<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\FatherName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\MotherName;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\FatherNameType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\MotherNameType;
use Project\Shared\Contracts\ArrayableInterface;

#[ORM\Embeddable]
class ParentsName implements ArrayableInterface
{
    #[ORM\Column(name: 'father_name', type: FatherNameType::NAME, nullable: true)]
    private FatherName $fatherName;

    #[ORM\Column(name: 'mother_name', type: MotherNameType::NAME, nullable: true)]
    private MotherName $motherName;

    public function __construct(FatherName $fatherName, MotherName $motherName)
    {
        $this->fatherName = $fatherName;
        $this->motherName = $motherName;
    }

    public static function make(FatherName $fatherName, MotherName $motherName): self
    {
        return new self($fatherName, $motherName);
    }

    public function getFatherName(): FatherName
    {
        return $this->fatherName;
    }

    public function changeFatherName(FatherName $fatherName): self
    {
        if ($this->fatherName->isNotEquals($fatherName)) {
            $this->fatherName = $fatherName;
        }

        return $this;
    }

    public function getMotherName(): MotherName
    {
        return $this->motherName;
    }

    public function changeMotherName(MotherName $motherName): self
    {
        if ($this->motherName->isNotEquals($motherName)) {
            $this->motherName = $motherName;
        }

        return $this;
    }

    public function isEquals(self $other): bool
    {
        return $this->fatherName->isEquals($other->getFatherName()) || $this->motherName->isEquals($other->getMotherName());
    }

    public function isNotEquals(self $other): bool
    {
        return $this->fatherName->isNotEquals($other->getFatherName()) || $this->motherName->isNotEquals($other->getMotherName());
    }

    public function toArray(): array
    {
        return [
            'father_name' => $this->fatherName->value,
            'mother_name' => $this->motherName->value,
        ];
    }
}
