<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Notification;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Notification\Domain\Manager\Manager;
use Project\Domains\Admin\Notification\Domain\Notification\Contracts\NotificationData;
use Project\Domains\Admin\Notification\Domain\Notification\Events\NotificationWasCreatedDomainEvent;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Payload;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Type;
use Project\Domains\Admin\Notification\Domain\Notification\ValueObjects\Uuid;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types\PayloadType;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types\TypeType;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Infrastructure\Repository\Doctrine\Enums\CascadeType;
use Project\Shared\Infrastructure\Repository\Doctrine\Enums\FetchType;

#[ORM\Entity]
#[ORM\Table(name: 'notification_notifications')]
#[ORM\HasLifecycleCallbacks]
class Notification extends AggregateRoot implements EntityUuid, TranslatableInterface
{
    use TranslatableTrait, CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: TypeType::NAME, nullable: true)]
    private Type $type;

    #[ORM\Column(type: PayloadType::NAME, nullable: true)]
    private Payload $payload;

    #[ORM\ManyToMany(targetEntity: Manager::class, inversedBy: 'notifications')]
    #[ORM\JoinTable(
        name: 'notification_notifications_managers',
        joinColumns: new ORM\JoinColumn(name: 'notification_uuid', referencedColumnName: 'uuid', nullable: false),
        inverseJoinColumns: new ORM\JoinColumn(name: 'manager_uuid', referencedColumnName: 'uuid', nullable: false)
    )]
    private Collection $viewedManagers;

    /**
     * @var NotificationTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: NotificationTranslation::class, mappedBy: 'object', cascade: [CascadeType::PERSIST->value, CascadeType::REMOVE->value], fetch: FetchType::EAGER->value)]
    private Collection $translations;

    private function __construct(
        Uuid $uuid,
        Type $type,
        Payload $payload
    ) {
        $this->uuid = $uuid;
        $this->type = $type;
        $this->payload = $payload;
        $this->viewedManagers = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public static function create(Uuid $uuid, NotificationData $notificationData): self
    {
        $companyNotification = new self(
            $uuid,
            Type::fromValue($notificationData->getType()),
            Payload::fromValue($notificationData->toPayload())
        );

        $companyNotification->record(
            new NotificationWasCreatedDomainEvent(
                $companyNotification->getUuid()->value
            )
        );

        return $companyNotification;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }

    public function getTranslationClass(): string
    {
        return NotificationTranslation::class;
    }

    public function addViewedManagers(Manager $manager): self
    {
        if (! $this->viewedManagers->contains($manager)) {
            $this->viewedManagers->add($manager);
        }

        return $this;
    }

    public function getViewedManagers(): Collection
    {
        return $this->viewedManagers;
    }
}