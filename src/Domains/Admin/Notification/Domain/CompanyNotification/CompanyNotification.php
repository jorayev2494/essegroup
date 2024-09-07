<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\CompanyNotification;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\Events\CompanyNotificationWasCreatedDomainEvent;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\CompanyUuid;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Content;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Tag;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Title;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\Uuid;
use Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Generators\UuidGenerator;
use Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\CompanyUuidType;
use Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\ContentType;
use Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\TagType;
use Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\TitleType;
use Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Infrastructure\Repository\Doctrine\Enums\CascadeType;
use Project\Shared\Infrastructure\Repository\Doctrine\Enums\FetchType;

#[ORM\Entity]
#[ORM\Table(name: 'notification_company_notifications')]
#[ORM\HasLifecycleCallbacks]
class CompanyNotification extends AggregateRoot implements EntityUuid, TranslatableInterface
{
    use TranslatableTrait, CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private Uuid $uuid;

    #[ORM\Column(name: 'company_uuid', type: CompanyUuidType::NAME)]
    private CompanyUuid $companyUuid;

    #[ORM\Column(type: TitleType::NAME, nullable: true)]
    private Title $title;

    #[ORM\Column(type: ContentType::NAME, nullable: true)]
    private Content $content;

    #[ORM\Column(type: TagType::NAME, nullable: true)]
    private Tag $tag;

    /**
     * @var CompanyNotificationTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: CompanyNotificationTranslation::class, mappedBy: 'object', cascade: [CascadeType::PERSIST->value, CascadeType::REMOVE->value], fetch: FetchType::EAGER->value)]
    private Collection $translations;

    private function __construct(
        CompanyUuid $companyUuid
    ) {
        $this->title = Title::fromValue(null);
        $this->content = Content::fromValue(null);
        $this->translations = new ArrayCollection();
    }

    public static function create(CompanyUuid $companyUuid): self
    {
        $companyNotification = new self($companyUuid);
        $companyNotification->record(
            new CompanyNotificationWasCreatedDomainEvent(
                $companyNotification->getUuid()->value,
                $companyNotification->companyUuid->value
            )
        );

        return $companyNotification;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return CompanyNotificationTranslation::class;
    }
}