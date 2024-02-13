<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\University\Subscribers;

use Project\Domains\Admin\Company\Domain\University\University;
use Project\Domains\Admin\Company\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\Company\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\Events\UniversityWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class UniversityWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public function __construct(
        private UniversityRepositoryInterface $universityRepository,
    )
    {

    }

    #[\Override]
    public static function subscribedTo(): array
    {
        return [
            UniversityWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(UniversityWasCreatedDomainEvent $event): void
    {
        $university = $this->universityRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($university !== null) {
            return;
        }

        $university = University::fromPrimitives($event->uuid, $event->slug);
    }
}
