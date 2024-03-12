<?php

namespace Project\Domains\Admin\Country\Domain\Country\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CountryWasDeleteDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
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
        ] = $body;

        return new self($uuid, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'admin_country.was.deleted';
    }

    /**
     * @inheritDoc
     */
    #[\Override]
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
