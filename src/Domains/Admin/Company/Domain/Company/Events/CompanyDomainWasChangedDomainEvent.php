<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CompanyDomainWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $domain,
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
            'domain' => $domain,
        ] = $body;

        return new self($uuid, $domain, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'company_company_domain.was.changed';
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
                'domain' => $this->domain,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
