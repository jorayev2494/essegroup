<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CompanyLogoWasDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $logoUuid,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'logo_uuid' => $logoUuid,
        ] = $body;

        return new self($uuid, $logoUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'company_logo.was.deleted';
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
                'logo_uuid' => $this->logoUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
