<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Translation\Contracts\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniversityRepositoryInterface     $repository,
        private FacultyRepositoryInterface        $facultyRepository,
        private TranslationColumnServiceInterface $translationService,
        private LogoServiceInterface          $logoService,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $faculty = $this->facultyRepository->findByUuid(Uuid::fromValue($command->uuid));

        $faculty ?? throw new ModelNotFoundException();

        $this->logoService->delete($faculty);
        $university = $faculty->getUniversity();
        $university->removeFaculty($faculty);
        // $this->repository->save($university);

        // $this->repository->save($university);
        // $faculty->changeIsActive($command->isActive);
        // $this->translationService->addTranslations($faculty, $command->translations);

        $this->facultyRepository->delete($faculty);
    }
}
