<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class CompanyEmailWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $email,
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
            'email' => $email,
        ] = $body;

        return new self($uuid, $email, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'company_company_email.was.changed';
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
                'email' => $this->email,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
