<?php

namespace Project\Domains\Admin\Country\Domain\Country\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CountryWasChangedCompanyDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $companyUuid,
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
            'company_uuid' => $companyUuid,
        ] = $body;

        return new self($uuid, $companyUuid, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'admin_country.was.changed.company';
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'company_uuid' => $this->companyUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
