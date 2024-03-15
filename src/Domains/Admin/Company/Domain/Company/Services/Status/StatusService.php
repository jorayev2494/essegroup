<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company\Services\Status;

use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Company\Services\Status\Contracts\StatusServiceInterface;
use Project\Domains\Admin\Company\Domain\Status\Status;

class StatusService implements StatusServiceInterface
{

    public function changeStatus(Company $company, Status $status): void
    {
//        if ($company->getStatus()->isNotEqualsValue($status->getValue())) {
//            $company->addStatues($status);
//        } else if ($company->getStatus()->isNotEqualsNote($status->getNote())) {
//            $company->getStatus()->setNote($status->getNote());
//        }
    }
}
