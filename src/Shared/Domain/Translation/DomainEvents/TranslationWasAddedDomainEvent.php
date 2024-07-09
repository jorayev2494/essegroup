<?php

namespace Project\Shared\Domain\Translation\DomainEvents;

use Project\Shared\Domain\Bus\Event\DomainEvent;

abstract readonly class TranslationWasAddedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $locale,
        public string $field,
        public string $content,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    #[\Override]
    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): static
    {
        [
            'uuid' => $uuid,
            'locale' => $locale,
            'field' => $field,
            'content' => $content,
        ] = $body;

        return new static($uuid, $locale, $field, $content, $eventId, $occurredOn);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function toArray(): array
    {
        return [
            'aggregate_id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'locale' => $this->locale,
                'field' => $this->field,
                'content' => $this->content,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
