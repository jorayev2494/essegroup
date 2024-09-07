<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class ManagerWasDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        ?string $eventId = null,
        ?string $occurredOn = null
    ) {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
        ] = $body;

        return new self($uuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'manager.was.deleted';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
