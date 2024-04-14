<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Commands\Update;

use Project\Domains\Admin\University\Domain\Application\Exceptions\StatusValueNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueBackgroundColor;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueTextColor;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StatusValueRepositoryInterface $statusValueRepository,
        private TranslationColumnServiceInterface $translationColumnService
    ) { }

    public function __invoke(Command $command): void
    {
        $statusValue = $this->statusValueRepository->findByUuid(StatusValueUuid::fromValue($command->uuid));

        $statusValue ?? throw new StatusValueNotFoundDomainException();

        $statusValue->setTextColor(StatusValueTextColor::fromValue($command->textColor));
        $statusValue->setBackgroundColor(StatusValueBackgroundColor::fromValue($command->backgroundColor));
        $statusValue->setIsRequiredNote($command->isRequiredNote);
        $statusValue->setIsFirst($command->isFirst);

        $this->translationColumnService->addTranslations($statusValue, $command->translations);

        $this->statusValueRepository->save($statusValue);
    }
}
