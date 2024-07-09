<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Name\Commands\Create;

use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyName;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FacultyNameRepositoryInterface    $nameRepository,
        private TranslationColumnServiceInterface $translationColumnService
    ) {

    }

    public function __invoke(Command $command): void
    {
        $name = FacultyName::create(
            Uuid::fromValue($command->uuid),
            $command->isActive
        );

        $this->translationColumnService->addTranslations($name, $command->translations);

        $this->nameRepository->save($name);
    }
}
