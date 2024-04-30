<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Domain\Announcement;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Content;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\ForItemEnum;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Title;
use Project\Domains\Admin\Announcement\Domain\Announcement\ValueObjects\Uuid;
use Project\Domains\Admin\Announcement\Infrastructure\Announcement\Repositories\Doctrine\Types\ContentType;
use Project\Domains\Admin\Announcement\Infrastructure\Announcement\Repositories\Doctrine\Types\ForType;
use Project\Domains\Admin\Announcement\Infrastructure\Announcement\Repositories\Doctrine\Types\TitleType;
use Project\Domains\Admin\Announcement\Infrastructure\Announcement\Repositories\Doctrine\Types\UuidType;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\ActivableTrait;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'announcement_announcements')]
#[ORM\HasLifecycleCallbacks]
class Announcement extends AggregateRoot implements EntityUuid, TranslatableInterface
{
    use TranslatableTrait,
        ActivableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: TitleType::NAME, nullable: true)]
    private Title $title;

    #[ORM\Column(type: ContentType::NAME, nullable: true)]
    private Content $content;

    /** @var AnnouncementTranslation[] $translations */
    #[ORM\OneToMany(targetEntity: AnnouncementTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    #[ORM\Column(name: 'start_time', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $startTime;

    #[ORM\Column(name: 'end_time', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $endTime;

    #[ORM\Column(name: 'author_uuid', type: Types::STRING, nullable: true)]
    private ?string $authorUuid;

    #[ORM\ManyToOne(targetEntity: Manager::class, inversedBy: 'announcements')]
    #[ORM\JoinColumn(name: 'author_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private Manager $author;

    #[ORM\Column(name: 'for_item', type: ForType::NAME)]
    private ForItemEnum $forItem;

    private function __construct(
        Uuid              $uuid,
        ForItemEnum       $forItem,
        DateTimeImmutable $startTime,
        Manager           $author,
        bool              $isActive
    ) {
        $this->uuid = $uuid;
        $this->forItem = $forItem;
        $this->title = Title::fromValue(null);
        $this->content = Content::fromValue(null);
        $this->translations = new ArrayCollection();
        $this->startTime = $startTime;
        $this->endTime = null;
        $this->author = $author;
        $this->isActive = $isActive;
    }

    public static function create(Uuid $uuid, ForItemEnum $for, DateTimeImmutable $startTime, Manager $author, bool $isActive): self
    {
        return new self($uuid, $for, $startTime, $author, $isActive);
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function changeForItem(ForItemEnum $forItem): self
    {
        if ($this->forItem->isNotEquals($forItem)) {
            $this->forItem = $forItem;
        }

        return $this;
    }

    public function changeTitle(Title $title): self
    {
        if ($this->title->isNotEquals($title)) {
            $this->title = $title;
        }

        return $this;
    }

    public function setContent(Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function changeContent(Content $content): self
    {
        if ($this->content->isNotEquals($content)) {
            $this->content = $content;
        }

        return $this;
    }

    public function changeStartTime(DateTimeImmutable $startTime): self
    {
        if ($this->startTime->getTimestamp() !== $startTime->getTimestamp()) {
            $this->startTime = $startTime;
        }

        return $this;
    }


    public function changeEndTime(?DateTimeImmutable $endTime): self
    {
        if ($this->endTime?->getTimestamp() !== $endTime?->getTimestamp()) {
            $this->endTime = $endTime;
        }

        return $this;
    }

    public function setEndTime(DateTimeImmutable $endTime): self
    {
        if ($this->endTime->getTimestamp() !== $endTime->getTimestamp()) {
            $this->endTime = $endTime;
        }

        return $this;
    }

    public function changeIsActive(bool $isActive): self
    {
        if ($this->isActive !== $isActive) {
            $this->isActive = $isActive;
        }

        return $this;
    }

    public function getTranslationClass(): string
    {
        return AnnouncementTranslation::class;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'for' => $this->forItem->value,
            'author' => $this->author?->toArray(),
            'title' => $this->title->value,
            'content' => $this->content->value,
            'start_time' => $this->startTime->getTimestamp(),
            'end_time' => $this->endTime?->getTimestamp(),
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
