<?php

namespace Project\Domains\Admin\University\Domain\Application\Services\Contracts;

use Doctrine\Common\Collections\Collection;
use Project\Domains\Admin\University\Domain\Application\Application;

interface ApplicationServiceInterface
{
    public function addDepartments(Application $application, array $departmentUuids): void;

    public function updateDepartments(Application $application, array $departmentUuids): void;

    public function removeDepartments(Application $application, Collection $departments): void;
}
