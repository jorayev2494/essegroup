<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\Services;

use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\StatusServiceInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;

class StatusService implements StatusServiceInterface
{
    #[\Override]
    public function changeStatus(Application $application, Status $status): void
    {
        if ($application->getStatus()->isNotEqualsValue($status->getValue())) {
            $application->addStatues($status);
        } else if ($application->getStatus()->isNotEqualsNote($status->getNote())) {
            $application->getStatus()->setNote($status->getNote());
        }
    }
}
