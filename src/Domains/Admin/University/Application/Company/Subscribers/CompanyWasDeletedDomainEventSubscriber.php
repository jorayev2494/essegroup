<?php

namespace Project\Domains\Admin\University\Application\Company\Subscribers;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyWasDeletedDomainEvent;
use Project\Domains\Admin\University\Application\Department\Commands\Delete\Command as DepartmentDeleteCommand;
use Project\Domains\Admin\University\Application\Department\Commands\Delete\CommandHandler as DepartmentDeleteCommandHandler;
use Project\Domains\Admin\University\Application\Faculty\Commands\Delete\Command as FacultyDeleteCommand;
use Project\Domains\Admin\University\Application\Faculty\Commands\Delete\CommandHandler as FacultyDeleteCommandHandler;
use Project\Domains\Admin\University\Application\University\Commands\Delete\Command as UniversityDeleteCommand;
use Project\Domains\Admin\University\Application\University\Commands\Delete\CommandHandler as UniversityDeleteCommandHandler;
use Project\Domains\Admin\University\Application\Application\Commands\Delete\Command as ApplicationDeleteCommand;
use Project\Domains\Admin\University\Application\Application\Commands\Delete\CommandHandler as ApplicationDeleteCommandHandler;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public function __construct(
        private CompanyRepositoryInterface $companyRepository
    )
    {

    }

    #[\Override]
    public static function subscribedTo(): array
    {
        return [
            CompanyWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(CompanyWasDeletedDomainEvent $event): void
    {
        $company = $this->companyRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($company === null) {
            return;
        }

//        /** @var CommandBusInterface $commandBus */
//        $commandBus = resolve(CommandBusInterface::class);
//
////        foreach ($company->getApplications() as $application) {
////            $commandBus->dispatch(new ApplicationDeleteCommand($application->getUuid()->value));
////        }
////
////        foreach ($company->getDepartments() as $department) {
////            $commandBus->dispatch(new DepartmentDeleteCommand($department->getUuid()->value));
////        }
////
////        foreach ($company->getFaculties() as $faculty) {
////            $commandBus->dispatch(new FacultyDeleteCommand($faculty->getUuid()->value));
////        }
//
//        foreach ($company->getUniversities() as $university) {
//            $commandBus->dispatch(new UniversityDeleteCommand($university->getUuid()->value));
//        }

        $this->companyRepository->delete($company);
    }
}
