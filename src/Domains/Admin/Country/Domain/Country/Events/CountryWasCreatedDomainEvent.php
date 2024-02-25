<?php

namespace Project\Domains\Admin\Country\Domain\Country\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CountryWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $value,
        public string $iso,
        public string $companyUuid,
        public bool $isActive,
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
            'iso' => $iso,
            'company_uuid' => $companyUuid,
            'is_active' => $isActive,
        ] = $body;

        return new self($uuid, $value, $iso, $companyUuid, $isActive, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'admin_country.was.created';
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
                'value' => $this->value,
                'iso' => $this->iso,
                'company_uuid' => $this->companyUuid,
                'is_active' => $this->isActive,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
