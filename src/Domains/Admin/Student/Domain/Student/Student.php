<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryTranslate;
use Project\Domains\Admin\Student\Domain\Student\Events\Auth\RestorePassword\StudentRestorePasswordLinkWasAddedDomainEvent;
use Project\Domains\Admin\Student\Domain\Student\Events\StudentWasCreatedDomainEvent;
use Project\Domains\Admin\Student\Domain\Student\Services\Avatar\Contracts\AvatarableInterface;
use Project\Domains\Admin\Student\Domain\Student\Services\Avatar\Contracts\AvatarInterface;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\AdditionalDocumentTrait;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\BiometricPhotoTrait;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\EquivalenceDocumentTrait;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\PassportTrait;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\PassportTranslationTrait;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\SchoolAttestatTrait;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\SchoolAttestatTranslationTrait;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\TranscriptTrait;
use Project\Domains\Admin\Student\Domain\Student\Traits\Files\TranscriptTranslationTrait;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Avatar;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Email;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables\FullName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables\HighSchool;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables\ParentsName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Embeddables\PassportInfo;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\Gender;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Enums\MaritalType;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Files\AdditionalDocument;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\FriendPhone;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\GradeAverage;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\HighSchoolName;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\HomeAddress;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Password;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Phone;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\EmailType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\FriendPhoneType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\GenderType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\HomeAddressType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\MaritalTypeType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\PasswordType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\PhoneType;
use Project\Domains\Admin\Student\Infrastructure\Student\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\BiometricPhoto\Contracts\BiometricPhotoableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Passport\Contracts\PassportableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\PassportTranslation\Contracts\PassportTranslationableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestat\Contracts\SchoolAttestateableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\Transcript\Contracts\TranscriptableInterface;
use Project\Domains\Admin\Student\Infrastructure\Student\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationableInterface;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Student\Authentication\Domain\Code\Code;
use Project\Domains\Student\Authentication\Domain\Device\Device;
use Project\Infrastructure\Services\Authentication\Contracts\AuthenticatableInterface;
use Project\Infrastructure\Services\Authentication\ValueObjects\PasswordValueObject;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'student_students')]
#[ORM\HasLifecycleCallbacks]
class Student extends AggregateRoot implements EntityUuid, AuthenticatableInterface,
    AvatarableInterface,
    AdditionalDocumentableInterface,
    PassportableInterface,
    SchoolAttestateableInterface,
    TranscriptableInterface,
    TranscriptTranslationableInterface,
    EquivalenceDocumentableInterface,
    PassportTranslationableInterface,
    SchoolAttestatTranslationableInterface,
    BiometricPhotoableInterface
{
    use PassportTrait,
        PassportTranslationTrait,
        SchoolAttestatTrait,
        TranscriptTrait,
        EquivalenceDocumentTrait,
        SchoolAttestatTranslationTrait,
        BiometricPhotoTrait,
        TranscriptTranslationTrait,
        AdditionalDocumentTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'avatar_uuid', nullable: true)]
    private string $avatarUuid;

    #[ORM\OneToOne(targetEntity: Avatar::class, inversedBy: 'student', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'avatar_uuid', referencedColumnName: 'uuid')]
    private ?Avatar $avatar;

    #[ORM\Embedded(class: FullName::class, columnPrefix: false)]
    private FullName $fullName;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private DateTimeImmutable $birthday;

    #[ORM\Embedded(class: ParentsName::class, columnPrefix: false)]
    private ParentsName $parentsName;

    #[ORM\Column(type: PasswordType::NAME, length: 100)]
    private Password $password;

    #[ORM\Column(name: 'gender', type: GenderType::NAME, length: 10, nullable: true)]
    private ?Gender $gender;

     #[ORM\Column(name: 'marital_type', type: MaritalTypeType::NAME, length: 10, nullable: true)]
    private ?MaritalType $maritalType;

    #[ORM\Column(type: PhoneType::NAME, length: 50)]
    private Phone $phone;

    #[ORM\Column(name: 'friend_phone', type: FriendPhoneType::NAME, length: 50, nullable: true)]
    private FriendPhone $friendPhone;

    #[ORM\Column(type: EmailType::NAME, length: 75, unique: true)]
    private Email $email;

    #[ORM\Embedded(class: PassportInfo::class, columnPrefix: 'passport_')]
    private PassportInfo $passportInfo;

    #[ORM\Column(name: 'home_address', type: HomeAddressType::NAME, nullable: true)]
    private HomeAddress $homeAddress;

    #[ORM\Column(name: 'company_uuid', nullable: true)]
    private ?string $companyUuid;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'students')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Company $company;

    #[ORM\OneToMany(targetEntity: AdditionalDocument::class, mappedBy: 'student', cascade: ['persist', 'remove'])]
    private Collection $additionalDocuments;

    #[ORM\Column(name: 'nationality_uuid', nullable: true)]
    private ?string $nationalityUuid;

    #[ORM\ManyToOne(targetEntity: Country::class, cascade: ['persist'], inversedBy: 'student')]
    #[ORM\JoinColumn(name: 'nationality_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?Country $nationality;

    #[ORM\Column(name: 'country_of_residence_uuid', nullable: true)]
    private ?string $countryOfResidenceUuid;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'student')]
    #[ORM\JoinColumn(name: 'country_of_residence_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private ?Country $countryOfResidence;

    #[ORM\Embedded(class: HighSchool::class, columnPrefix: 'high_school_')]
    private HighSchool $highSchool;

    #[ORM\Column(name: 'high_school_country_uuid', type: Types::GUID, nullable: true)]
    private string $highSchoolCountryUuid;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'studentHighSchools')]
    #[ORM\JoinColumn(name: 'high_school_country_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Country $highSchoolCountry;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'student')]
    private Collection $applications;

    #[ORM\Column(name: 'creator_role', length: 10, nullable: false)]
    private string $creatorRole;

    #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $devices;

    #[ORM\OneToOne(targetEntity: Code::class, mappedBy: 'author', cascade: ['persist', 'remove'], orphanRemoval: true)]
    public ?Code $code;

    private function __construct(
        Uuid $uuid,
        FullName $fullName,
        ParentsName $parentsName,
        DateTimeImmutable $birthday,
        PassportInfo $passportInfo,
        Email $email,
        Phone $phone,
        Company $company,
        Country $nationality,
        Country $countryOfResidence,
        Country $highSchoolCountry,
        Password $password,
        string $creatorRole
    ) {
        $this->uuid = $uuid;
        $this->fullName = $fullName;
        $this->parentsName = $parentsName;
        $this->birthday = $birthday;
        $this->passportInfo = $passportInfo;
        $this->email = $email;
        $this->phone = $phone;
        $this->company = $company;
        $this->nationality = $nationality;
        $this->countryOfResidence = $countryOfResidence;
        $this->highSchool = HighSchool::make(
            HighSchoolName::fromValue(null),
            GradeAverage::fromValue(null)
        );
        $this->highSchoolCountry = $highSchoolCountry;
        $this->creatorRole = $creatorRole;
        $this->password = $password;
        $this->friendPhone = FriendPhone::fromValue(null);
        $this->homeAddress = HomeAddress::fromValue(null);
        $this->additionalDocuments = new ArrayCollection();
        $this->avatar = null;
        $this->gender = null;
        $this->maritalType = null;
        $this->devices = new ArrayCollection();
    }

    public static function create(
        Uuid $uuid,
        FullName $fullName,
        ParentsName $parentsName,
        DateTimeImmutable $birthday,
        PassportInfo $passportInfo,
        Email $email,
        Phone $phone,
        Company $company,
        Country $nationality,
        Country $countryOfResidence,
        Country $highSchoolCountry,
        Password $password,
        string $creatorRole
    ): self
    {
        $student = new self(
            $uuid,
            $fullName,
            $parentsName,
            $birthday,
            $passportInfo,
            $email,
            $phone,
            $company,
            $nationality,
            $countryOfResidence,
            $highSchoolCountry,
            $password,
            $creatorRole
        );

        $student->record(
            new StudentWasCreatedDomainEvent(
                $uuid->value,
                $fullName->getFirstName()->value,
                $fullName->getLastName()->value,
                $email->value,
                $password->value
            )
        );

        return $student;
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function getParentsName(): ParentsName
    {
        return $this->parentsName;
    }

    public function changeBirthday(DateTimeImmutable $birthday): self
    {
        if ($this->birthday->getTimestamp() !== $birthday->getTimestamp()) {
            $this->birthday = $birthday;
        }

        return $this;
    }

    public function changeGender(Gender $gender): self
    {
        if ($this->gender === null || $this->gender->isNotEquals($gender)) {
            $this->gender = $gender;
        }

        return $this;
    }

    public function changeMaritalType(MaritalType $maritalType): self
    {
        if ($this->maritalType === null || $this->maritalType->isNotEquals($maritalType)) {
            $this->maritalType = $maritalType;
        }

        return $this;
    }

    public function changeFriendPhone(FriendPhone $friendPhone): self
    {
        if ($this->friendPhone->isNotEquals($friendPhone)) {
            $this->friendPhone = $friendPhone;
        }

        return $this;
    }

    public function changeHomeAddress(HomeAddress $homeAddress): self
    {
        if ($this->homeAddress->isNotEquals($homeAddress)) {
            $this->homeAddress = $homeAddress;
        }

        return $this;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function changeCompany(Company $company): self
    {
        if ($this->company->isNotEqual($company)) {
            $this->company = $company;
        }

        return $this;
    }

    public function changeNationality(Country $nationality): self
    {
        if ($this->nationality->isNotEquals($nationality)) {
            $this->nationality = $nationality;
        }

        return $this;
    }

    public function changeCountryOfResidence(Country $countryOfResidence): self
    {
        if ($this->countryOfResidence->isNotEquals($countryOfResidence)) {
            $this->countryOfResidence = $countryOfResidence;
        }

        return $this;
    }

    public function changeEmail(Email $email): self
    {
        if ($this->email->isNotEquals($email)) {
            $this->email = $email;
        }

        return $this;
    }

    public function getPassportInfo(): PassportInfo
    {
        return $this->passportInfo;
    }

    public function changePhone(Phone $phone): void
    {
        if ($this->phone->isNotEquals($phone)) {
            $this->phone = $phone;
        }
    }

    public function getHighSchool(): HighSchool
    {
        return $this->highSchool;
    }

    public function changeHighSchool(HighSchool $highSchool): self
    {
        if ($this->highSchool->isNotEquals($highSchool)) {
            $this->highSchool = $highSchool;
        }

        return $this;
    }

    public function changeHighSchoolCountry(Country $highSchoolCountry): self
    {
        if ($this->highSchoolCountry->isNotEquals($highSchoolCountry)) {
            $this->highSchoolCountry = $highSchoolCountry;
        }

        return $this;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function changeAvatar(?AvatarInterface $avatar): static
    {
        if ($this->avatar === null || $this->avatar->isNotEquals($avatar)) {
            $this->avatar = $avatar;
        }

        return $this;
    }

    public function deleteAvatar(): static
    {
        return $this;
    }

    public function changePassword(Password $password): void
    {
        $this->password = $password;
    }

    public function isEqual(self $other): bool
    {
        return $this->uuid->value === $other->getUuid()->value;
    }

    public function isNotEqual(self $other): bool
    {
        return $this->uuid->value !== $other->getUuid()->value;
    }

    #[\Override]
    public function getClaims(): array
    {
        return [
            'company_uuid' => $this->companyUuid,
        ];
    }

    public function getPassword(): PasswordValueObject
    {
        return $this->password;
    }

    public function setPassword(Password $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): void
    {
        $this->devices->add($device);
        $device->setAuthor($this);
    }

    public function getCode(): ?Code
    {
        return $this->code;
    }

    public function hasCode(): bool
    {
        return $this->code instanceof (Code::class);
    }

    public function addCode(Code $code): void
    {
        $this->code = $code;
        $code->setAuthor($this);
        $this->record(
            new StudentRestorePasswordLinkWasAddedDomainEvent(
                $this->uuid->value,
                $this->email->value,
                $this->getFullName()->getFirstName()->value,
                $this->getFullName()->getLastName()->value,
                $code->getValue()
            )
        );
    }

    public function removeCode(): void
    {
        $this->code?->setAuthor(null);
        $this->code = null;
    }

    #[ORM\PrePersist]
    public function prePersisting(PrePersistEventArgs $event): void
    {
        $this->createdAt = $this->createdAt ?? new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        if ($this->createdAt->getTimestamp() === $this->updatedAt->getTimestamp()) {
            $this->password = Password::fromValue($this->password->hash());
        }
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            ...$this->fullName->toArray(),
            'avatar' => $this->avatar?->toArray(),
            'birthday' => $this->birthday->getTimestamp(),
            'gender' => $this->gender?->value,
            'marital_type' => $this->maritalType?->value,
            ...$this->parentsName->toArray(),
            ...$this->passportInfo->toArray(),
            'company_uuid' => $this->company->getUuid()->value,
            'company' => $this->company->getUuid()->isNotNull() ? $this->company->toArray() : null,
            'nationality_uuid' => $this->nationality->getUuid()->value,
            'nationality' => CountryTranslate::execute($this->nationality)?->toArray(),
            'country_of_residence_uuid' => $this->countryOfResidence->getUuid()->value,
            'country_of_residence' => CountryTranslate::execute($this->countryOfResidence)?->toArray(),
            ...$this->highSchool->toArray(),
            'high_school_country_uuid' => $this->highSchoolCountry->getUuid()->value,
            'high_school_country' => CountryTranslate::execute($this->highSchoolCountry)?->toArray(),
            'phone' => $this->phone->value,
            'friend_phone' => $this->friendPhone->value,
            'home_address' => $this->homeAddress->value,
            'email' => $this->email->value,
            'passport' => $this->passport->toArray(),
            'school_attestat' => $this->schoolAttestat->toArray(),
            'equivalence_document' => $this->equivalenceDocument->toArray(),
            'passport_translation' => $this->passportTranslation->toArray(),
            'transcript' => $this->transcript->toArray(),
            'transcript_translation' => $this->transcriptTranslation->toArray(),
            'school_attestat_translation' => $this->schoolAttestatTranslation->toArray(),
            'biometric_photo' => $this->biometricPhoto->toArray(),
            'additional_documents' => array_map(
                static fn (AdditionalDocument $additionalDocument): array => $additionalDocument->toArray(),
                $this->additionalDocuments->toArray()
            ),
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
