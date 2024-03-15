<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Subscribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Admin\University\Application\Application\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    function __construct(
        private ApplicationRepositoryInterface $applicationRepository
    )
    {

    }

    public static function subscribedTo(): array
    {
        return [
            CompanyWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasDeletedDomainEvent $event): void
    {
        $applications = $this->applicationRepository->findManyByCompanyUuid($event->uuid);

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $applications->forAll(static function (int $idx, Application $application) use($commandBus): bool {
            $commandBus->dispatch(new Command($application->getUuid()->value));

            return true;
        });
    }
}
