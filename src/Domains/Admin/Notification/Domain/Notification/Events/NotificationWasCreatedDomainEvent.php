<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\Notification\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class NotificationWasCreatedDomainEvent extends DomainEvent
{

    public function __construct(
        public string $uuid,
        public ?string $eventId = null,
        public ?string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        return new self($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'notification.was.created';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [

            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}