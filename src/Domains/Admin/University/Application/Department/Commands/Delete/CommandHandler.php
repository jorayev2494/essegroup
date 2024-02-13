<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Department\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\University\Domain\Department\DepartmentRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Department\Services\Translation\Contracts\TranslationColumnServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $department = $this->departmentRepository->findByUuid(Uuid::fromValue($command->uuid));

        $department ?? throw new ModelNotFoundException();

        $this->departmentRepository->delete($department);
    }
}
