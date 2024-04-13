<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Subsribers\Company;

use Project\Domains\Admin\Company\Domain\Company\Events\CompanyLogoWasDeletedDomainEvent;
use Project\Domains\Admin\Company\Domain\Company\LogoRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

readonly class CompanyLogoWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    function __construct(
        private LogoRepositoryInterface $logoRepository
    ) { }

    public static function subscribedTo(): array
    {
        return [
            CompanyLogoWasDeletedDomainEvent::class
        ];
    }

    public function __invoke(CompanyLogoWasDeletedDomainEvent $event): void
    {
        $logo = $this->logoRepository->findByUuid($event->logoUuid);

        if ($logo === null) {
            return;
        }

        $this->logoRepository->delete($logo);
    }
}
