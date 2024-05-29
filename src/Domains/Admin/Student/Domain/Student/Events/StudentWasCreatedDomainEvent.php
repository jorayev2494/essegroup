<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class StudentWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'uuid' => $uuid,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
        ] = $body;

        return new self($uuid, $firstName, $lastName, $email, $password, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'student.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'password' => $this->password,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
