<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\Services;

use Doctrine\Common\Collections\Collection;
use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\ApplicationServiceInterface;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;

readonly class ApplicationService implements ApplicationServiceInterface
{

    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    )
    {

    }

    #[\Override]
    public function addDepartments(Application $application, array $departmentUuids): void
    {
        $departments = $this->departmentRepository->findManyByUuids(
            array_map(
                static fn (string $uuid): Uuid => Uuid::fromValue($uuid),
                $departmentUuids
            )
        );

        $departments->forEach(static function (Department $department) use ($application): void {
            $application->addDepartment($department);
        });
    }

    public function updateDepartments(Application $application, array $departmentUuids): void
    {
        $this->removeDepartments($application, $application->getDepartments());
        $this->addDepartments($application, $departmentUuids);
    }

    public function removeDepartments(Application $application, Collection $departments): void
    {
        $departments->forAll(static fn (int $idx, Department $department) => $application->removeDepartment($department));
    }
}