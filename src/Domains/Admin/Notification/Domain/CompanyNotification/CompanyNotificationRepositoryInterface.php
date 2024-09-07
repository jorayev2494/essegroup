<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\CompanyNotification;

interface CompanyNotificationRepositoryInterface
{
    public function save(CompanyNotification $companyNotification): void;
}