<?php

namespace Project\Domains\Admin\University\Domain\Application\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class ApplicationWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'application.was.created';
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
