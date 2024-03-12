<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\Traits\AdditionalDocumentTrait;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\AdditionalDocument;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\BiometricPhoto;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Email;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\EquivalenceDocument;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FatherName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FriendPhone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\FullName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\HomeAddress;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\MotherName;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\PassportNumber;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\PassportTranslation;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Phone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Passport;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\SchoolAttestat;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\SchoolAttestatTranslation;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Transcript;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\TranscriptTranslation;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Company\Company;
use Project\Domains\Admin\University\Domain\Country\Country;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\EmailType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\FatherNameType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\FriendPhoneType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\FullNameType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\HomeAddressType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\MotherNameType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\PassportNumberType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\PhoneType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\AdditionalDocument\Contracts\AdditionalDocumentableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\Contracts\BiometricPhotoableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\BiometricPhoto\Contracts\BiometricPhotoInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\EquivalenceDocument\Contracts\EquivalenceDocumentInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\Contracts\PassportableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\Contracts\PassportInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts\PassportTranslationableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\PassportTranslation\Contracts\PassportTranslationInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\Contracts\SchoolAttestateableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestat\Contracts\SchoolAttestatInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\SchoolAttestatTranslation\Contracts\SchoolAttestatTranslationInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts\TranscriptableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Transcript\Contracts\TranscriptInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationableInterface;
use Project\Domains\Admin\University\Infrastructure\Application\Services\Files\TranscriptTranslation\Contracts\TranscriptTranslationInterface;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'university_applications')]
#[ORM\HasLifecycleCallbacks]
class Application extends AggregateRoot implements
    ArrayableInterface,
    PassportableInterface,
    SchoolAttestateableInterface,
    TranscriptableInterface,
    TranscriptTranslationableInterface,
    EquivalenceDocumentableInterface,
    PassportTranslationableInterface,
    SchoolAttestatTranslationableInterface,
    BiometricPhotoableInterface,
    AdditionalDocumentableInterface
{

    use AdditionalDocumentTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'full_name', type: FullNameType::NAME)]
    private FullName $fullName;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $birthday;

    #[ORM\Column(name: 'father_name', type: FatherNameType::NAME, nullable: true)]
    private FatherName $fatherName;

    #[ORM\Column(name: 'mother_name', type: MotherNameType::NAME, nullable: true)]
    private MotherName $motherName;

    #[ORM\Column(name: 'passport_number', type: PassportNumberType::NAME)]
    private PassportNumber $passportNumber;

    #[ORM\Column(type: PhoneType::NAME)]
    private Phone $phone;

    #[ORM\Column(name: 'friend_phone', type: FriendPhoneType::NAME, nullable: true)]
    private FriendPhone $friendPhone;

    #[ORM\Column(type: EmailType::NAME)]
    private Email $email;

    #[ORM\Column(name: 'home_address', type: HomeAddressType::NAME, nullable: true)]
    private HomeAddress $homeAddress;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'company_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Company $company;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'university_uuid', referencedColumnName: 'uuid', nullable: false)]
    private University $university;

//    #[ORM\ManyToOne(targetEntity: Faculty::class, inversedBy: 'applications')]
//    #[ORM\JoinColumn(name: 'faculty_uuid', referencedColumnName: 'uuid', nullable: false)]
//    private Faculty $faculty;

    #[ORM\ManyToMany(targetEntity: Department::class, inversedBy: 'applications')]
    #[ORM\JoinTable(
        name: 'university_applications_departments',
        joinColumns: new ORM\JoinColumn(name: 'application_uuid', referencedColumnName: 'uuid', nullable: false),
        inverseJoinColumns: new ORM\JoinColumn(name: 'department_uuid', referencedColumnName: 'uuid', nullable: false)
    )]
    private Collection $departments;

    #[ORM\ManyToOne(targetEntity: Passport::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'passport_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Passport $passport;

    #[ORM\ManyToOne(targetEntity: SchoolAttestat::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'school_attestat_uuid', referencedColumnName: 'uuid', nullable: false)]
    private SchoolAttestat $schoolAttestat;

    #[ORM\ManyToOne(targetEntity: EquivalenceDocument::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'equivalence_document_uuid', referencedColumnName: 'uuid', nullable: false)]
    private EquivalenceDocument $equivalenceDocument;

    #[ORM\ManyToOne(targetEntity: PassportTranslation::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'passport_translation_uuid', referencedColumnName: 'uuid', nullable: false)]
    private PassportTranslation $passportTranslation;

    #[ORM\ManyToOne(targetEntity: Transcript::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'transcript_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Transcript $transcript;

    #[ORM\ManyToOne(targetEntity: TranscriptTranslation::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'transcript_translation_uuid', referencedColumnName: 'uuid', nullable: false)]
    private TranscriptTranslation $transcriptTranslation;

    #[ORM\ManyToOne(targetEntity: SchoolAttestatTranslation::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'school_attestat_translation_uuid', referencedColumnName: 'uuid', nullable: false)]
    private SchoolAttestatTranslation $schoolAttestatTranslation;

    #[ORM\ManyToOne(targetEntity: BiometricPhoto::class, cascade: ['persist', 'remove'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'biometric_photo_uuid', referencedColumnName: 'uuid', nullable: false)]
    private BiometricPhoto $biometricPhoto;

    #[ORM\OneToMany(targetEntity: AdditionalDocument::class, mappedBy: 'application', cascade: ['persist', 'remove'])]
    private Collection $additionalDocuments;

    #[ORM\ManyToOne(targetEntity: Country::class, cascade: ['persist'], inversedBy: 'application')]
    #[ORM\JoinColumn(name: 'country_uuid', referencedColumnName: 'uuid')]
    private Country $country;

    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'application', cascade: ['persist', 'remove'])]
    private Collection $statuses;

    #[ORM\Column(name: 'creator_role', nullable: false)]
    private string $creatorRole;

    #[ORM\Column(name: 'is_agreed_to_share_data', type: Types::BOOLEAN)]
    private bool $isAgreedToShareData;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    private function __construct(
        Uuid $uuid,
        FullName $fullName,
        DateTimeImmutable $birthday,
        PassportNumber $passportNumber,
        Email $email,
        Phone $phone,
        Company $company,
        University $university,
        Country $country,
        bool $isAgreedToShareData,
        string $creatorRole
    ) {
        $this->uuid = $uuid;
        $this->fullName = $fullName;
        $this->birthday = $birthday;
        $this->passportNumber = $passportNumber;
        $this->email = $email;
        $this->phone = $phone;
        $this->company = $company;
        $this->university = $university;
        $this->country = $country;
        $this->isAgreedToShareData = $isAgreedToShareData;
        $this->creatorRole = $creatorRole;
        $this->fatherName = FatherName::fromValue(null);
        $this->motherName = MotherName::fromValue(null);
        $this->friendPhone = FriendPhone::fromValue(null);
        $this->homeAddress = HomeAddress::fromValue(null);
        $this->departments = new ArrayCollection();
        $this->additionalDocuments = new ArrayCollection();
        $this->statuses = new ArrayCollection();
    }

    public static function create(
        Uuid $uuid,
        FullName $fullName,
        DateTimeImmutable $birthday,
        PassportNumber $passportNumber,
        Email $email,
        Phone $phone,
        Company $company,
        University $university,
        Country $country,
        bool $isAgreedToShareData,
        string $creatorRole
    ): self
    {
        $application = new self($uuid, $fullName, $birthday, $passportNumber, $email, $phone, $company, $university, $country, $isAgreedToShareData, $creatorRole);
        $application->addStatues(Status::fromPrimitives(StatusEnum::PENDING->value));

        return $application;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function changeFullName(FullName $fullName): void
    {
        if ($this->fullName->isNotEquals($fullName)) {
            $this->fullName = $fullName;
        }
    }

    public function changeBirthday(DateTimeImmutable $birthday): void
    {
        if ($this->birthday->getTimestamp() !== $birthday->getTimestamp()) {
            $this->birthday = $birthday;
        }
    }

    public function changePassportNumber(PassportNumber $passportNumber): void
    {
        if ($this->passportNumber->isNotEquals($passportNumber)) {
            $this->passportNumber = $passportNumber;
        }
    }

    public function setFatherName(FatherName $fatherName): void
    {
        $this->fatherName = $fatherName;
    }

    public function changeFatherName(FatherName $fatherName): void
    {
        if ($this->fatherName->isNotEquals($fatherName)) {
            $this->setFatherName($fatherName);
        }
    }

    public function changeMotherName(MotherName $motherName): void
    {
        if ($this->motherName->isNotEquals($motherName)) {
            $this->setMotherName($motherName);
        }
    }

    public function setMotherName(MotherName $motherName): void
    {
        $this->motherName = $motherName;
    }

    public function changeFriendPhone(FriendPhone $friendPhone): void
    {
        if ($this->friendPhone->isNotEquals($friendPhone)) {
            $this->setFriendPhone($friendPhone);
        }
    }

    public function setFriendPhone(FriendPhone $friendPhone): void
    {
        $this->friendPhone = $friendPhone;
    }

    public function changeHomeAddress(HomeAddress $homeAddress): void
    {
        if ($this->homeAddress->isNotEquals($homeAddress)) {
            $this->setHomeAddress($homeAddress);
        }
    }

    public function setHomeAddress(HomeAddress $homeAddress): void
    {
        $this->homeAddress = $homeAddress;
    }

    public function changeCompany(Company $company): void
    {
        if ($this->company->getUuid()->value !== $company->getUuid()->value) {
            $this->company = $company;
        }
    }

    public function changeUniversity(University $university): void
    {
        if ($this->university->isNotEquals($university)) {
            $this->university = $university;
        }
    }

    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): void
    {
        if (! $this->departments->contains($department)) {
            $this->departments->add($department);
            // $department->addApplication($this);
        }
    }

    public function removeDepartment(Department $department): void
    {
        if ($this->departments->contains($department)) {
            // $department->removeApplication($this);
            $this->departments->removeElement($department);
        }
    }

    public function changeCountry(Country $country): void
    {
        if ($this->country->isNotEquals($country)) {
            $this->country = $country;
        }
    }

    public function changeEmail(Email $email): void
    {
        if ($this->email->isNotEquals($email)) {
            $this->email = $email;
        }
    }

    public function changePhone(Phone $phone): void
    {
        if ($this->phone->isNotEquals($phone)) {
            $this->phone = $phone;
        }
    }

    public function addStatues(Status $status): void
    {
        $this->statuses->add($status);
        $status->setApplication($this);
    }

    public function getStatuses(): ArrayCollection
    {
        return $this->statuses;
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
    public function getPassport(): Passport
    {
        return $this->passport;
    }

    #[\Override]
    public function changePassport(PassportInterface $passport): void
    {
        $this->passport = $passport;
    }

    public function getStatus(): Status
    {
        return $this->statuses->last();
    }

    #[\Override]
    public function getPassportClassName(): string
    {
        return Passport::class;
    }

    #[\Override]
    public function deletePassport(): void
    {
        // TODO: Implement deletePassport() method.
    }

    #[\Override]
    public function getSchoolAttestatClassName(): string
    {
        return SchoolAttestat::class;
    }

    #[\Override]
    public function getSchoolAttestat(): SchoolAttestat
    {
        return $this->schoolAttestat;
    }

    #[\Override]
    public function changeSchoolAttestat(SchoolAttestatInterface $schoolAttestat): void
    {
        $this->schoolAttestat = $schoolAttestat;
    }

    #[\Override]
    public function deleteSchoolAttestat(): void
    {
        // TODO: Implement deleteSchoolAttestat() method.
    }

    #[\Override]
    public function getTranscriptClassName(): string
    {
        return Transcript::class;
    }

    #[\Override]
    public function getTranscript(): Transcript
    {
        return $this->transcript;
    }

    #[\Override]
    public function changeTranscript(TranscriptInterface $transcript): void
    {
        $this->transcript = $transcript;
    }

    #[\Override]
    public function deleteTranscript(): void
    {
        // TODO: Implement deleteTranscript() method.
    }

    #[\Override]
    public function getEquivalenceDocumentClassName(): string
    {
        return EquivalenceDocument::class;
    }

    #[\Override]
    public function getEquivalenceDocument(): EquivalenceDocument
    {
        return $this->equivalenceDocument;
    }

    #[\Override]
    public function changeEquivalenceDocument(EquivalenceDocumentInterface $equivalenceDocument): void
    {
        $this->equivalenceDocument = $equivalenceDocument;
    }

    #[\Override]
    public function deleteEquivalenceDocument(): void
    {
        // TODO: Implement deleteEquivalenceDocument() method.
    }

    #[\Override]
    public function getPassportTranslationClassName(): string
    {
        return PassportTranslation::class;
    }

    #[\Override]
    public function getPassportTranslation(): PassportTranslation
    {
        return $this->passportTranslation;
    }

    #[\Override]
    public function changePassportTranslation(PassportTranslationInterface $passportTranslation): void
    {
        $this->passportTranslation = $passportTranslation;
    }

    #[\Override]
    public function deletePassportTranslation(): void
    {
        // TODO: Implement deletePassportTranslation() method.
    }

    #[\Override]
    public function getSchoolAttestatTranslationClassName(): string
    {
        return SchoolAttestatTranslation::class;
    }

    #[\Override]
    public function getSchoolAttestatTranslation(): SchoolAttestatTranslation
    {
        return $this->schoolAttestatTranslation;
    }

    #[\Override]
    public function changeSchoolAttestatTranslation(SchoolAttestatTranslationInterface $schoolAttestatTranslation): void
    {
        $this->schoolAttestatTranslation = $schoolAttestatTranslation;
    }

    #[\Override]
    public function deleteSchoolAttestatTranslation(): void
    {
        // TODO: Implement deleteSchoolAttestatTranslation() method.
    }

    #[\Override]
    public function getBiometricPhotoClassName(): string
    {
        return BiometricPhoto::class;
    }

    #[\Override]
    public function getBiometricPhoto(): BiometricPhoto
    {
        return $this->biometricPhoto;
    }

    #[\Override]
    public function changeBiometricPhoto(BiometricPhotoInterface $biometricPhoto): void
    {
        $this->biometricPhoto = $biometricPhoto;
    }

    #[\Override]
    public function deleteBiometricPhoto(): void
    {
        // TODO: Implement deleteBiometricPhoto() method.
    }

    #[\Override]
    public function getTranscriptTranslationClassName(): string
    {
        return TranscriptTranslation::class;
    }

    #[\Override]
    public function getTranscriptTranslation(): TranscriptTranslation
    {
        return $this->transcriptTranslation;
    }

    #[\Override]
    public function changeTranscriptTranslation(TranscriptTranslationInterface $transcriptTranslation): void
    {
        $this->transcriptTranslation = $transcriptTranslation;
    }

    #[\Override]
    public function deleteTranscriptTranslation(): void
    {
        // TODO: Implement deleteTranscriptTranslation() method.
    }

    #[\Override]
    public function toArray(): array
    {
        // $this->additionalDocuments->forAll(static fn (int $k, AdditionalDocument $additionalDocument): array => $additionalDocument->toArray());

        return [
            'uuid' => $this->uuid->value,
            'full_name' => $this->fullName->value,
            'birthday' => $this->birthday->getTimestamp(),
            'father_name' => $this->fatherName->value,
            'mother_name' => $this->motherName->value,
            'passport_number' => $this->passportNumber->value,
            'company_uuid' => $this->company->getUuid()->value,
            'company' => $this->company->toArray(),
            'country_uuid' => $this->country->getUuid(),
            'country' => $this->country->toArray(),
            'university_uuid' => $this->university->getUuid()->value,
            'university' => $this->university->toArray(),
//            'faculty_uuid' => $this->faculty->getUuid()->value,
//            'faculty' => $this->faculty->toArray(),
            'departments' => array_map(static fn (ArrayableInterface $item): array => $item->toArray(), $this->departments->toArray()),
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
            'status' => $this->getStatus()->toArray(),
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
