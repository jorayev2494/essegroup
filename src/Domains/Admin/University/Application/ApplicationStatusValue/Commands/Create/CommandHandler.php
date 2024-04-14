<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Commands\Create;

use Project\Domains\Admin\University\Domain\Application\StatusValue;
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
        $statusValue = StatusValue::create(
            StatusValueUuid::fromValue($command->uuid),
            StatusValueTextColor::fromValue($command->textColor),
            StatusValueBackgroundColor::fromValue($command->backgroundColor),
            $command->isRequiredNote,
            $command->isFirst
        );

        $this->translationColumnService->addTranslations($statusValue, $command->translations);

        $this->statusValueRepository->save($statusValue);
    }
}
