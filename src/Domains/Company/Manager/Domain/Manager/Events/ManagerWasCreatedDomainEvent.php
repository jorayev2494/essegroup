<?php

namespace Project\Domains\Company\Manager\Domain\Manager\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class ManagerWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $email,
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
            'email' => $email,
            'company_uuid' => $companyUuid,
        ] = $body;

        return new self($uuid, $email, $companyUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'company_domain_manager.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'email' => $this->email,
                'company_uuid' => $this->companyUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
