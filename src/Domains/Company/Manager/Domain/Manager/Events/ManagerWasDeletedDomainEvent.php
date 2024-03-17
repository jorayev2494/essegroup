<?php

namespace Project\Domains\Company\Manager\Domain\Manager\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class ManagerWasDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $companyUuid,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'company_uuid' => $companyUuid,
        ] = $body;

        return new self($uuid, $companyUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'company_domain_manager.was.deleted';
    }

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
