<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Subscribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Admin\University\Application\University\Commands\Delete\Command;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    function __construct(
        private UniversityRepositoryInterface $universityRepository
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
        $universities = $this->universityRepository->findManyByCompanyUuid($event->uuid);

        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);
        $universities->forAll(static function (int $idx, University $university) use($commandBus): bool {
            $commandBus->dispatch(new Command($university->getUuid()->value));

            return true;
        });
    }
}
