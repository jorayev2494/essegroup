<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Role\Commands\Create;

use Project\Domains\Admin\Manager\Domain\Role\Role;
use Project\Domains\Admin\Manager\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Role\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository,
        private TranslationColumnServiceInterface $translationColumnService
    ) { }

    public function __invoke(Command $command): void
    {
        $role = Role::create(
            Uuid::fromValue($command->uuid),
        );

        $this->translationColumnService->addTranslations($role, $command->translations);
        $role->setIsActive($command->isActive);

        $this->roleRepository->save($role);
    }
}