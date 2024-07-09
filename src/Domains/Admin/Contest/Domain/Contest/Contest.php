<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\Contest;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Description;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Title;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudent;
use Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine\Types\DescriptionType;
use Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine\Types\TitleType;
use Project\Domains\Admin\Contest\Infrastructure\Contest\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Country\Domain\Country\Country;
use Project\Domains\Admin\Country\Domain\Country\CountryTranslate;
use Project\Domains\Admin\University\Domain\Application\StatusValue;
use Project\Domains\Admin\University\Domain\Application\StatusValueTranslate;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'contest_contests')]
#[ORM\HasLifecycleCallbacks]
class Contest implements EntityUuid, TranslatableInterface, ArrayableInterface
{
    use TranslatableTrait,
        ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'participants_number', type: Types::INTEGER)]
    private int $participantsNumber;

    #[ORM\Column(type: TitleType::NAME, nullable: true)]
    private Title $title;

    #[ORM\Column(type: DescriptionType::NAME, nullable: true)]
    private Description $description;

    #[ORM\ManyToMany(targetEntity: StatusValue::class, inversedBy: 'contests')]
    #[ORM\JoinTable(
        name: 'contest_contests_university_application_statuses',
        joinColumns: new ORM\JoinColumn(name: 'contest_uuid', referencedColumnName: 'uuid', nullable: false),
        inverseJoinColumns: new ORM\JoinColumn(name: 'application_status_uuid', referencedColumnName: 'uuid', nullable: false)
    )]
    private Collection $applicationStatuses;

    #[ORM\ManyToMany(targetEntity: Country::class, inversedBy: 'contests')]
    #[ORM\JoinTable(
        name: 'contest_contests_university_country_countries',
        joinColumns: new ORM\JoinColumn(name: 'contest_uuid', referencedColumnName: 'uuid', nullable: false),
        inverseJoinColumns: new ORM\JoinColumn(name: 'country_country_uuid', referencedColumnName: 'uuid', nullable: false)
    )]
    private Collection $studentNationalities;

    #[ORM\OneToMany(targetEntity: WonStudent::class, mappedBy: 'contest', cascade: ['persist'])]
    private Collection $wonStudents;

    /**
     * @var ContestTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: ContestTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $startTime;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $endTime;

    public function __construct(Uuid $uuid, int $participantsNumber, DateTimeImmutable $startTime)
    {
        $this->uuid = $uuid;
        $this->participantsNumber = $participantsNumber;
        $this->title = Title::fromValue(null);
        $this->description = Description::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->applicationStatuses = new ArrayCollection();
        $this->studentNationalities = new ArrayCollection();
        $this->wonStudents = new ArrayCollection();
        $this->startTime = $startTime;
        $this->endTime = null;
        $this->isActive = true;
    }

    public static function create(Uuid $uuid, int $participantsNumber, DateTimeImmutable $startTime): self
    {
        return new self($uuid, $participantsNumber, $startTime);
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    public function changeParticipantsNumber(int $participantsNumber): self
    {
        if ($this->participantsNumber !== $participantsNumber) {
            $this->participantsNumber = $participantsNumber;
        }

        return $this;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function setDescription(Description $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getApplicationStatuses(): Collection
    {
        return $this->applicationStatuses;
    }

    public function addApplicationStatus(StatusValue $status): self
    {
        if (! $this->applicationStatuses->contains($status)) {
            $this->applicationStatuses->add($status);
        }

        return $this;
    }

    public function getStudentNationalities(): Collection
    {
        return $this->studentNationalities;
    }

    public function addStudentNationality(Country $country): self
    {
        if (! $this->studentNationalities->contains($country)) {
            $this->studentNationalities->add($country);
        }

        return $this;
    }

    public function getWonStudents(): array
    {
        return $this->wonStudents->toArray();
    }

    public function removeWinnerStudent(WonStudent $wonStudent): self
    {
        if ($this->wonStudents->contains($wonStudent)) {
            $this->wonStudents->removeElement($wonStudent);
        }

        return $this;
    }

    public function setStartTime(DateTimeImmutable $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function setEndTime(?DateTimeImmutable $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return ContestTranslation::class;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'participants_number' => $this->participantsNumber,
            'title' => $this->title->value,
            'description' => $this->description->value,
            'application_statuses' => $this->applicationStatuses->map(
                static fn (StatusValue $statusValue): array => StatusValueTranslate::execute($statusValue)->toArray()
            )->toArray(),
            'student_nationalities' => $this->studentNationalities->map(
                static fn (Country $country): array => CountryTranslate::execute($country)->toArray()
            )->toArray(),
            'start_time' => $this->startTime->getTimestamp(),
            'end_time' => $this->endTime?->getTimestamp(),
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
