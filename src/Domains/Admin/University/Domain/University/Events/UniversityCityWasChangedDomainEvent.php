<?php

namespace Project\Domains\Admin\University\Domain\University\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class UniversityCityWasChangedDomainEvent extends DomainEvent
{

    public function __construct(
        public string $uuid,
        public string $cityUuid,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'city_uuid' => $cityUuid,
        ] = $body;

        return new self($uuid, $cityUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'university_city.was.changed';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'city_uuid' => $this->cityUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
