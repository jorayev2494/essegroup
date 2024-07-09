<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class UniversityWasDeletedDomainEvent extends DomainEvent
{

    public function __construct(
        public string $uuid,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    #[\Override]
    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'uuid' => $uuid,
        ] = $body;

        return new self($uuid, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'university_university.was.deleted';
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'aggregate_id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
