<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Create;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private DegreeRepositoryInterface $degreeRepository,
        private FacultyRepositoryInterface $facultyRepository,
        private TranslationColumnServiceInterface $translationService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $faculty = $this->facultyRepository->findByUuid(FacultyUuid::fromValue($command->facultyUuid));

        $faculty ?? throw new ModelNotFoundException();

        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));

        $degrees = $this->degreeRepository->findManyByUuids(...array_map(static fn (string $uuid): Uuid => Uuid::fromValue($uuid), $command->degreeUuids));

        $department = Department::fromPrimitives(
            $command->uuid,
            $company,
            $faculty->getUniversity(),
            new ArrayCollection(iterator_to_array($degrees->getIterator())),
            $command->isActive
        );

        $department->changeIsFilled($command->isFilled);

        $this->translationService->addTranslations($department, $command->translations);

        $faculty->addDepartments($department);

        $this->facultyRepository->save($faculty);
    }
}
