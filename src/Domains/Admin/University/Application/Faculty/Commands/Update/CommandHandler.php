<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Translation\Contracts\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FacultyRepositoryInterface $facultyRepository,
        private TranslationColumnServiceInterface $translationService,
        private LogoServiceInterface $logoService,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $faculty = $this->facultyRepository->findByUuid(Uuid::fromValue($command->uuid));

        $faculty ?? throw new ModelNotFoundException();

        $faculty->changeIsActive($command->isActive);
        $faculty->changeUniversityUuid($command->universityUuid);

        $this->translationService->addTranslations($faculty, $command->translations);
        $this->logoService->update($faculty, $command->logo);

        $this->facultyRepository->save($faculty);
    }
}
