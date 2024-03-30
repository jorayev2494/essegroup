<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid as DegreeUuid;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private DegreeRepositoryInterface $degreeRepository,
        private FacultyRepositoryInterface $facultyRepository,
        private DepartmentRepositoryInterface $departmentRepository,
        private TranslationColumnServiceInterface $translationService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $faculty = $this->facultyRepository->findByUuid(FacultyUuid::fromValue($command->facultyUuid));
        $department = $this->departmentRepository->findByUuid(Uuid::fromValue($command->uuid));

        $department ?? throw new ModelNotFoundException();

        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));
        $degrees = $this->degreeRepository->findManyByUuids(...array_map(static fn (string $uuid): DegreeUuid => DegreeUuid::fromValue($uuid), $command->degreeUuids));

        $department->setIsActive($command->isActive);
        $department->changeCompany($company);
        $department->changeUniversity($faculty->getUniversity());
        $department->changeFaculty($faculty);
        $department->changeIsFilled($command->isFilled);

        $department->clearDegrees();
        $degrees->forEach(static fn (Degree $degree): Department => $department->addDegree($degree));

        $this->translationService->addTranslations($department, $command->translations);

        $this->departmentRepository->save($department);
    }
}
