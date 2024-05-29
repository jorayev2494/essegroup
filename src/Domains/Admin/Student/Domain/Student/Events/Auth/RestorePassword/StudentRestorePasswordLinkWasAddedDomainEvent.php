<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Events\Auth\RestorePassword;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class StudentRestorePasswordLinkWasAddedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $codeValue,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'uuid' => $uuid,
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'code_value' => $codeValue,
        ] = $body;

        return new self($uuid, $email, $firstName, $lastName, $codeValue, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'student_forgot_password_code.was.added';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'email' => $this->email,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'code_value' => $this->codeValue,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
