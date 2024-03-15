<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\Services\Contracts;

use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;

interface StatusServiceInterface
{
    public function changeStatus(Application $application, Status $status, array $noteTranslations): void;
}
