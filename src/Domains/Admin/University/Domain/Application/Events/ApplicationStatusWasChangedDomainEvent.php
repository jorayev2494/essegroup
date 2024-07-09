<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class ApplicationStatusWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $statusValueUuid,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'student_value_uuid' => $statusValueUuid,
        ] = $body;

        return new self($uuid, $statusValueUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_domain.application_status.was.changed';
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
                'student_value_uuid' => $this->statusValueUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
