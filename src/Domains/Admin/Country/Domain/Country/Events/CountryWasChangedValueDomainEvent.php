<?php

namespace Project\Domains\Admin\Country\Domain\Country\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CountryWasChangedValueDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $value,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    #[\Override]
    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'value' => $value,
        ] = $body;

        return new self($uuid, $value, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'admin_country.was.changed.value';
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'value' => $this->value,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
