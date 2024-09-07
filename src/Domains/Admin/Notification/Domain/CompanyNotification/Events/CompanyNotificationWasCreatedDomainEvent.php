<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\CompanyNotification\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CompanyNotificationWasCreatedDomainEvent extends DomainEvent
{

    public function __construct(
        public string $uuid,
        public string $companyUuid,
        public ?string $eventId = null,
        public ?string $occurredOn = null
    )
    {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'company_uuid' => $companyUuid,
        ] = $body;

        return new self($id, $companyUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'company_notification.was.created';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'company_uuid' => $this->companyUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}