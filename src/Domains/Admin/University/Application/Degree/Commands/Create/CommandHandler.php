<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Degree\Commands\Create;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DegreeRepositoryInterface $degreeRepository,
        private TranslationColumnServiceInterface $translationColumnService
    ) {

    }

    public function __invoke(Command $command): void
    {
        $degree = Degree::create(
            Uuid::fromValue($command->uuid),
            $command->isActive
        );

        $this->translationColumnService->addTranslations($degree, $command->translations);

        $this->degreeRepository->save($degree);
    }
}
