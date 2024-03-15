<?php

namespace Project\Domains\Admin\Company\Domain\Company\Services\Status\Contracts;

use Project\Domains\Admin\Company\Domain\Company\Company;
use Project\Domains\Admin\Company\Domain\Status\Status;

interface StatusServiceInterface
{
    public function changeStatus(Company $company, Status $status): void;
}
