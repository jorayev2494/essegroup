<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Faculty\FacultyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Services\Logo\Contracts\LogoServiceInterface;
use Project\Domains\Admin\University\Domain\Faculty\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\UniversityRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FacultyRepositoryInterface $facultyRepository,
        private LogoServiceInterface $logoService,
        private EventBusInterface $eventBus
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $faculty = $this->facultyRepository->findByUuid(Uuid::fromValue($command->uuid));

        $faculty ?? throw new ModelNotFoundException();

        $this->logoService->delete($faculty);
        // $university = $faculty->getUniversity();
        // $university->removeFaculty($faculty);

        $faculty->delete();
        $this->facultyRepository->delete($faculty);
        $this->eventBus->publish(...$faculty->pullDomainEvents());
    }
}
