<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\DepartmentName\Commands\Create;

use Project\Domains\Admin\University\Domain\Department\Name\DepartmentName;
use Project\Domains\Admin\University\Domain\Department\Name\DepartmentNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Department\Name\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DepartmentNameRepositoryInterface $nameRepository,
        private TranslationColumnServiceInterface $translationColumnService
    ) {

    }

    public function __invoke(Command $command): void
    {
        $departmentName = DepartmentName::create(
            Uuid::fromValue($command->uuid),
            true
        );

        $this->translationColumnService->addTranslations($departmentName, $command->translations);

        $this->nameRepository->save($departmentName);
    }
}
