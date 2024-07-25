<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Permission\Commands\Create;

use Project\Domains\Admin\Manager\Domain\Permission\Permission;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Action;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Resource;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepository,
        private TranslationColumnServiceInterface $translationColumnService
    ) { }

    public function __invoke(Command $command): void
    {
        $permission = Permission::create(
            Resource::fromValue($command->resource),
            Action::fromValue($command->action)
        );

        $this->translationColumnService->addTranslations($permission, $command->translations);
        $permission->setIsActive($command->isActive);

        $this->permissionRepository->save($permission);
    }
}