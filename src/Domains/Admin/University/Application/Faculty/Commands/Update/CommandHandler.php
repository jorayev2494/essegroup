<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid as FacultyNameUuid;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid as UniversityUuid;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
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
        $faculty = $this->facultyRepository->findByUuid(Uuid::fromValue($command->uuid));
        $name = $this->nameRepository->findByUuid(FacultyNameUuid::fromValue($command->nameUuid));

        $faculty ?? throw new ModelNotFoundException();

        $university = $this->repository->findByUuid(UniversityUuid::fromValue($command->universityUuid));

        $faculty->changeIsActive($command->isActive);

        $faculty->setName($name);
        $faculty->changeUniversity($university);
        $this->translationService->addTranslations($faculty, $command->translations);
        $this->logoService->update($faculty, $command->logo);

        $this->facultyRepository->save($faculty);
    }
}
