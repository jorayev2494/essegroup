<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid as DegreeUuid;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DegreeRepositoryInterface $degreeRepository,
        private DepartmentRepositoryInterface $departmentRepository,
        private TranslationColumnServiceInterface $translationService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $department = $this->departmentRepository->findByUuid(Uuid::fromValue($command->uuid));

        $department ?? throw new ModelNotFoundException();

        $degrees = $this->degreeRepository->findManyByUuids(...array_map(static fn (string $uuid): DegreeUuid => DegreeUuid::fromValue($uuid), $command->degreeUuids));

        $department->setIsActive($command->isActive);
        $department->changeIsFilled($command->isFilled);

        $department->clearDegrees();
        $degrees->forEach(static fn (Degree $degree): Department => $department->addDegree($degree));

        $this->translationService->addTranslations($department, $command->translations);

        $this->departmentRepository->save($department);
    }
}
