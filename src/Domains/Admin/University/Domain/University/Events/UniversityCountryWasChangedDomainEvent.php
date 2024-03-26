<?php

namespace Project\Domains\Admin\University\Domain\University\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class UniversityCountryWasChangedDomainEvent extends DomainEvent
{

    public function __construct(
        public string $uuid,
        public string $countryUuid,
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
            'country_uuid' => $countryUuid,
        ] = $body;

        return new self($uuid, $countryUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'university_country.was.changed';
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
                'country_uuid' => $this->countryUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
