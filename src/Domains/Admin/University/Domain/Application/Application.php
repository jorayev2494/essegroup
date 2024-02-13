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
use Project\Domains\Admin\University\Domain\Application\ValueObjects\BiometricPhoto;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Email;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\EquivalenceDocument;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\PassportTranslation;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Phone;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Passport;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\SchoolAttestat;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\SchoolAttestatTranslation;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Transcript;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\TranscriptTranslation;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\EmailType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\PhoneType;
use Project\Domains\Admin\University\Infrastructure\Application\Repositories\Doctrine\Types\UuidType;
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

#[ORM\Entity]
#[ORM\Table(name: 'university_applications')]
#[ORM\HasLifecycleCallbacks]
class Application implements
    ArrayableInterface,
    PassportableInterface,
    SchoolAttestateableInterface,
    TranscriptableInterface,
    TranscriptTranslationableInterface,
    EquivalenceDocumentableInterface,
    PassportTranslationableInterface,
    SchoolAttestatTranslationableInterface,
    BiometricPhotoableInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: EmailType::NAME)]
    private Email $email;

    #[ORM\Column(type: PhoneType::NAME)]
    private Phone $phone;

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

    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'application', cascade: ['persist', 'remove'])]
    private Collection $statuses;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    private function __construct(Uuid $uuid, Email $email, Phone $phone)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->phone = $phone;
        $this->statuses = new ArrayCollection();
    }

    public static function create(Uuid $uuid, Email $email, Phone $phone): self
    {
        $application = new self($uuid, $email, $phone);
        $application->addStatues(Status::fromPrimitives(StatusEnum::NEW->value));

        return $application;
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
        return [
            'uuid' => $this->uuid->value,
            'email' => $this->email->value,
            'phone' => $this->phone->value,
            'passport' => $this->passport->toArray(),
            'school_attestat' => $this->schoolAttestat->toArray(),
            'equivalence_document' => $this->equivalenceDocument->toArray(),
            'passport_translation' => $this->passportTranslation->toArray(),
            'transcript' => $this->transcript->toArray(),
            'transcript_translation' => $this->transcriptTranslation->toArray(),
            'school_attestat_translation' => $this->schoolAttestatTranslation->toArray(),
            'biometric_photo' => $this->biometricPhoto->toArray(),
            'status' => $this->getStatus()->toArray(),
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
