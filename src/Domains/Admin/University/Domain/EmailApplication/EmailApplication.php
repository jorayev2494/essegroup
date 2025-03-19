<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\EmailApplication;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\AdditionalPhone;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\FatherFirstName;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\FirstName;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\LastName;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\MotherFirstName;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\Note;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\Phone;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types\AdditionalPhoneType;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types\FatherFirstNameType;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types\FirstNameType;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types\LastNameType;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types\MotherFirstNameType;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types\NoteType;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types\PhoneType;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;

#[ORM\Entity]
#[ORM\Table(name: 'university_email_applications')]
#[ORM\HasLifecycleCallbacks]
class EmailApplication
{
    use CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'first_name', type: FirstNameType::NAME)]
    private FirstName $firstName;

    #[ORM\Column(name: 'last_name', type: LastNameType::NAME)]
    private LastName $lastName;

    #[ORM\Column(name: 'father_first_name', type: FatherFirstNameType::NAME)]
    private FatherFirstName $fatherFirstName;

    #[ORM\Column(name: 'mother_first_name', type: MotherFirstNameType::NAME)]
    private MotherFirstName $motherFirstName;

    #[ORM\Column(type: PhoneType::NAME)]
    private Phone $phone;

    #[ORM\Column(name: 'additional_phone', type: AdditionalPhoneType::NAME, nullable: true)]
    private AdditionalPhone $additionalPhone;

    #[ORM\Column(type: NoteType::NAME, nullable: true)]
    private Note $note;

    private function __construct(
        Uuid $uuid,
        FirstName $firstName,
        LastName $lastName,
        FatherFirstName $fatherFirstName,
        MotherFirstName $motherFirstName,
        Phone $phone,
        AdditionalPhone $additionalPhone,
        Note $note
    ) {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->fatherFirstName = $fatherFirstName;
        $this->motherFirstName = $motherFirstName;
        $this->phone = $phone;
        $this->additionalPhone = $additionalPhone;
        $this->note = $note;
    }

    public static function create(
        Uuid $uuid,
        FirstName $firstName,
        LastName $lastName,
        FatherFirstName $fatherFirstName,
        MotherFirstName $motherFirstName,
        Phone $phone,
        AdditionalPhone $additionalPhone,
        Note $note
    ): self
    {
        return new self(
            $uuid,
            $firstName,
            $lastName,
            $fatherFirstName,
            $motherFirstName,
            $phone,
            $additionalPhone,
            $note
        );
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getFistName(): FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function getFatherFirstName(): FatherFirstName
    {
        return $this->fatherFirstName;
    }

    public function getMotherFirstName(): MotherFirstName
    {
        return $this->motherFirstName;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getAdditionalPhone(): AdditionalPhone
    {
        return $this->additionalPhone;
    }

    public function getNote(): Note
    {
        return $this->note;
    }
}