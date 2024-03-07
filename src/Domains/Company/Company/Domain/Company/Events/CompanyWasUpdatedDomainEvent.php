<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Domain\Company\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CompanyWasUpdatedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $domain,
        public string $status,
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
            'name' => $name,
            'domain' => $domain,
        ] = $body;

        return new self($uuid, $name, $domain, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'company_company.was.updated';
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            [
                'uuid' => $this->uuid,
                'name' => $this->name,
                'domain' => $this->domain,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
