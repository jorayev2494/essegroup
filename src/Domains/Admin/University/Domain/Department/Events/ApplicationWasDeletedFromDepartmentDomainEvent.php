<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class ApplicationWasDeletedFromDepartmentDomainEvent extends DomainEvent
{
    function __construct(
        public string $uuid,
        public string $applicationUuid,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }
    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'application_uuid' => $applicationUuid,
        ] = $body;

        return new self($uuid, $applicationUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_department_application.was.deleted';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'application_uuid' => $this->applicationUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
