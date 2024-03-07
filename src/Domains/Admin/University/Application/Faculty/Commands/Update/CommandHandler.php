<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid as UniversityUuid;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Translation\Contracts\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository,
        private FacultyRepositoryInterface $facultyRepository,
        private CompanyRepositoryInterface $companyRepository,
        private TranslationColumnServiceInterface $translationService,
        private LogoServiceInterface $logoService,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $faculty = $this->facultyRepository->findByUuid(Uuid::fromValue($command->uuid));

        $faculty ?? throw new ModelNotFoundException();

        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));
        $university = $this->repository->findByUuid(UniversityUuid::fromValue($command->universityUuid));

        $faculty->changeIsActive($command->isActive);
        $faculty->changeUniversity($university);
        $faculty->changeCompany($company);

        $this->translationService->addTranslations($faculty, $command->translations);
        $this->logoService->update($faculty, $command->logo);

        $this->facultyRepository->save($faculty);
    }
}
