<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Commands\Create;

use Project\Domains\Admin\University\Domain\Faculty\Faculty;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid as FacultyUuid;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid as FacultyNameUuid;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface $repository,
        private FacultyRepositoryInterface $facultyRepository,
        private FacultyNameRepositoryInterface $nameRepository,
        private TranslationColumnServiceInterface $translationService,
        private LogoServiceInterface $logoService
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $university = $this->repository->findByUuid(Uuid::fromValue($command->universityUuid));
        $name = $this->nameRepository->findByUuid(FacultyNameUuid::fromValue($command->nameUuid));

        $faculty = Faculty::create(
            FacultyUuid::fromValue($command->uuid),
            $name,
            $university,
            $command->isActive
        );

        $this->translationService->addTranslations($faculty, $command->translations);
        $this->logoService->upload($faculty, $command->logo);

        // $this->repository->save($university);
        $this->facultyRepository->save($faculty);
    }
}
