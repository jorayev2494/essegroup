<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Application\CompanyNotification\Commands\Create;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\CompanyNotification;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\CompanyNotificationRepositoryInterface;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\ValueObjects\CompanyUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private TranslationColumnServiceInterface $translationColumnService,
        private CompanyNotificationRepositoryInterface $companyNotificationRepository,
        private EventBusInterface $eventBus
    ) { }

    public function __invoke(Command $command): void
    {
        $company = $this->companyRepository->findByUuid(Uuid::fromValue($command->companyUuid));

        if ($company === null) {
            return;
        }

        $companyNotification = CompanyNotification::create(
            CompanyUuid::fromValue($company->getUuid()->value)
        );

        $this->translationColumnService->addTranslations($companyNotification, $command->translations);
        $this->companyNotificationRepository->save($companyNotification);
        $this->eventBus->publish(...$companyNotification->pullDomainEvents());
    }
}