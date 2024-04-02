<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Applications\Language\Commands\Update;

use Project\Domains\Admin\Language\Domain\Language\Exceptions\LanguageNotFoundDomainException;
use Project\Domains\Admin\Language\Domain\Language\Language;
use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LanguageRepositoryInterface $repository,
        private TranslationColumnServiceInterface $translationColumnService
    ) {

    }

    public function __invoke(Command $command): void
    {
        $language = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $language ?? throw new LanguageNotFoundDomainException();

        $this->translationColumnService->addTranslations($language, $command->translations);

        $this->repository->save($language);
    }
}
