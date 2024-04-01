<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Create;

use Doctrine\Common\Collections\ArrayCollection;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository,
        private DegreeRepositoryInterface $degreeRepository,
        private TranslationColumnServiceInterface $translationService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $degrees = $this->degreeRepository->findManyByUuids(...array_map(static fn (string $uuid): Uuid => Uuid::fromValue($uuid), $command->degreeUuids));

        $department = Department::fromPrimitives(
            $command->uuid,
            new ArrayCollection(iterator_to_array($degrees->getIterator())),
            $command->isActive
        );

        $department->changeIsFilled($command->isFilled);

        $this->translationService->addTranslations($department, $command->translations);

        $this->departmentRepository->save($department);
    }
}
