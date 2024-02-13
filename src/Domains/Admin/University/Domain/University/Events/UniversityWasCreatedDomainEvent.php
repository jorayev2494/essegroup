<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class UniversityWasCreatedDomainEvent extends DomainEvent
{

    public function __construct(
        public string $uuid,
        public string $slug,
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
            'slug' => $slug,
        ] = $body;

        return new self($uuid, $slug, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'university_university.was.created';
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'aggregate_id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'slug' => $this->slug,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
