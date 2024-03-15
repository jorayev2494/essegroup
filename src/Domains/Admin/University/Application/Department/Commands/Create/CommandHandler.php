<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Create;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
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

        $department = Department::fromPrimitives(
            $command->uuid,
            $company,
            $faculty->getUniversity(),
            $command->isActive
        );

        $this->translationService->addTranslations($department, $command->translations);

        $faculty->addDepartments($department);

        $this->facultyRepository->save($faculty);
    }
}
