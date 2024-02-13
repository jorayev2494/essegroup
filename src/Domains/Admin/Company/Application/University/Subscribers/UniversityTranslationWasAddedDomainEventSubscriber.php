<?php

namespace Project\Domains\Admin\Company\Application\University\Subscribers;

use Project\Domains\Admin\University\Domain\University\Events\Translation\UniversityTranslationWasAddedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class UniversityTranslationWasAddedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(

    )
    {

    }

    #[\Override]
    public static function subscribedTo(): array
    {
        return [
            UniversityTranslationWasAddedDomainEvent::class,
        ];
    }

    public function __invoke(UniversityTranslationWasAddedDomainEvent $event): void
    {

    }
}
