<?php

namespace Project\Domains\Admin\University\Infrastructure\Application\Notifications\NotificationData;

use Project\Domains\Admin\Notification\Domain\Notification\Contracts\NotificationData;
use Project\Domains\Admin\Student\Domain\Student\StudentRepositoryInterface;
use Project\Domains\Admin\Student\Domain\Student\ValueObjects\Uuid;

readonly class ApplicationWasCreatedDomainEventNotificationData extends NotificationData
{
    public const TYPE = 'application_was_created';

    private string $title;

    public function __construct(
        private string $uuid,
        private string $studentUuid
    ) {
        $this->title = 'application.notify.application_was_created';
    }

    public static function fromArray(array $data): static
    {
        return new self(
            $data['uuid'],
            $data['student_uuid']
        );
    }

    public function toPayload(): array
    {
        return [
            'uuid' => $this->uuid,
            'student_uuid' => $this->studentUuid,
        ];
    }

    public function toNotification(): array
    {
        /** @var StudentRepositoryInterface $studentRepositoryInterface */
        $studentRepositoryInterface = resolve(StudentRepositoryInterface::class);
        $student = $studentRepositoryInterface->findByUuid(Uuid::fromValue($this->studentUuid));

        if ($student !== null) {
            $student = [
                'uuid' => $student->getUuid()->value,
                'full_name' => $student->getFullName()->getFullName(),
                'avatar' => $student->getAvatar()?->toArray(),
            ];
        }

        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'student' => $student,
        ];
    }
}