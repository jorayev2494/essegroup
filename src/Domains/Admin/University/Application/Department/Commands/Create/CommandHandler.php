<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Create;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Services\Translation\Contracts\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FacultyRepositoryInterface $facultyRepository,
        private TranslationColumnServiceInterface $translationService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $faculty = $this->facultyRepository->findByUuid(FacultyUuid::fromValue($command->facultyUuid));

        $faculty ?? throw new ModelNotFoundException();

        $department = Department::fromPrimitives(
            $command->uuid,
            $command->isActive
        );

        $this->translationService->addTranslations($department, $command->translations);

        $faculty->addDepartments($department);

        $this->facultyRepository->save($faculty);
    }
}
