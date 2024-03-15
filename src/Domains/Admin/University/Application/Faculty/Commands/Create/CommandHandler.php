<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Commands\Create;

use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository,
        private CompanyRepositoryInterface $companyRepository,
        private TranslationColumnServiceInterface $translationService,
        private LogoServiceInterface $logoService,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));
        $university = $this->repository->findByUuid(Uuid::fromValue($command->universityUuid));

        $faculty = Faculty::create(
            FacultyUuid::fromValue($command->uuid),
            $company,
            $command->isActive
        );

        $this->translationService->addTranslations($faculty, $command->translations);
        $this->logoService->upload($faculty, $command->logo);

        $university->addFaculty($faculty);
        $this->repository->save($university);
    }
}
