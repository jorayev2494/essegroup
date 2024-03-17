<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Application\Manager\Subscribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasCreatedDomainEvent;
use Project\Domains\Company\Manager\Application\Manager\Commands\Create\Command;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator
    )
    {

    }

    public static function subscribedTo(): array
    {
        return [
            CompanyWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasCreatedDomainEvent $event): void
    {
        $uuid = $this->uuidGenerator->generate();

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new Command(
                $uuid,
                $event->email,
                $event->uuid
            )
        );
    }
}
