<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Subscribers\Application;

use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\Events\ApplicationWasCreatedDomainEvent;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\Application\Notifications\NotificationData\ApplicationWasCreatedDomainEventNotificationData;
use Project\Infrastructure\Services\Notification\Contracts\NotificationServiceInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ApplicationWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $repository,
        private NotificationServiceInterface $notificationService,
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ApplicationWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ApplicationWasCreatedDomainEvent $event): void
    {
        $application = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        if ($application === null) {
            return;
        }

        $this->notificationService->create(
            new ApplicationWasCreatedDomainEventNotificationData(
                $application->getUuid()->value,
                $application->getStudent()->getUuid()->value
            )
        );
    }
}