<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Notification\Domain\Manager\ValueObjects\Uuid;
use Project\Domains\Admin\Notification\Domain\Notification\Notification;
use Project\Domains\Admin\Notification\Infrastructure\Manager\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table(name: 'notification_managers')]
#[ORM\HasLifecycleCallbacks]
class Manager implements EntityUuid
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\ManyToMany(targetEntity: Notification::class, mappedBy: 'viewedManagers')]
    private Collection $notifications;

    private function __construct(
        Uuid $uuid
    )
    {
        $this->uuid = $uuid;
        $this->notifications = new ArrayCollection();
    }

    public static function make(Uuid $uuid): self
    {
        return new self($uuid);
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }
}