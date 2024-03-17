<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Application\Authentication\Subscribers\Manager;

use Project\Domains\Company\Authentication\Application\Authentication\Commands\Delete\Command;
use Project\Domains\Company\Manager\Domain\Manager\Events\ManagerWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class ManagerWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public static function subscribedTo(): array
    {
        return [
            ManagerWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerWasDeletedDomainEvent $event): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new Command(
                $event->uuid,
                $event->companyUuid
            )
        );
    }
}
