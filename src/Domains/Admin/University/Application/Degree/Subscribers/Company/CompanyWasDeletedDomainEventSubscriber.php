<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Degree\Subscribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Admin\University\Application\Degree\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private DegreeRepositoryInterface $degreeRepository
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            CompanyWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasDeletedDomainEvent $event): void
    {
        $degrees = $this->degreeRepository->findManyByCompanyUuid($event->uuid);

        if ($degrees->isEmpty()) {
            return;
        }

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $degrees->forEach(static function (Degree $degree) use($commandBus): void {
            $commandBus->dispatch(new Command($degree->getUuid()->value));
        });
    }
}
