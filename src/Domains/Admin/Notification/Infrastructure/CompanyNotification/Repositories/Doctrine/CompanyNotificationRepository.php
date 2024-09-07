<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Infrastructure\CompanyNotification\Repositories\Doctrine;

use Project\Domains\Admin\Notification\Domain\CompanyNotification\CompanyNotification;
use Project\Domains\Admin\Notification\Domain\CompanyNotification\CompanyNotificationRepositoryInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class CompanyNotificationRepository extends BaseAdminEntityRepository implements CompanyNotificationRepositoryInterface
{
    protected function getEntity(): string
    {
        return CompanyNotification::class;
    }

    public function save(CompanyNotification $companyNotification): void
    {
        $this->getEntityManager()->persist($companyNotification);
        $this->getEntityManager()->flush();
    }
}