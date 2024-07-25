<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Permission\Commands\Update;

use Project\Domains\Admin\Manager\Domain\Permission\Exceptions\PermissionNotFoundDomainException;
use Project\Domains\Admin\Manager\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Permission\ValueObjects\Id;
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
        $permission = $this->permissionRepository->findById(Id::fromValue($command->id));

        $permission ?? throw new PermissionNotFoundDomainException();

        $this->translationColumnService->addTranslations($permission, $command->translations);
        $permission->setIsActive($command->isActive);

        $this->permissionRepository->save($permission);
    }
}