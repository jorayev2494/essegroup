<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Application\Authentication\Subscribers\Manager;

use Project\Domains\Company\Authentication\Application\Authentication\Commands\Create\Command;
use Project\Domains\Company\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ManagerWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(

    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ManagerWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerWasCreatedDomainEvent $event): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new Command(
                $event->uuid,
                $event->email,
                $event->companyUuid
            )
        );
    }
}
