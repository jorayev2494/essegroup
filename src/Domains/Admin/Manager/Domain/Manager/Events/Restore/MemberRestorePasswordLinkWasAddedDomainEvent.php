<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\Events\Restore;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class MemberRestorePasswordLinkWasAddedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $email,
        public string $codeValue,
        string $eventIs = null,
        string $occurredOn = null
    ) {
        parent::__construct($this->uuid, $eventIs, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'email' => $email,
            'code_value' => $codeValue,
        ] = $body;

        return new self($uuid, $email, $codeValue, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_domain_auth_restore_password_link.was.added';
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
                'email' => $this->email,
                'code_value' => $this->codeValue,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
