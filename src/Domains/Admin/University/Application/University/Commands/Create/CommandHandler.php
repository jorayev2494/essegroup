<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\University\Commands\Create;

use Project\Domains\Admin\University\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\University\Domain\University\Services\Translation\Contracts\TranslationColumnServiceInterface;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\ValueObjects\YouTubeVideoId;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts\LogoServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        // private UniversityRepositoryInterface $repository,
        private CompanyRepositoryInterface        $companyRepository,
        private TranslationColumnServiceInterface $translationColumnService,
        private LogoServiceInterface          $logoService,
        private CoverServiceInterface             $coverService,
        private EventBusInterface                 $eventBus
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $company = $this->companyRepository->findByUuid(CompanyUuid::fromValue($command->companyUuid));

        $university = University::create(
            Uuid::fromValue($command->uuid),
            YouTubeVideoId::fromValue($command->youtubeVideoId)
        );

        $this->translationColumnService->addTranslations($university, $command->translations);

        $company->addUniversity($university);
        $this->logoService->update($university, $command->logo);
        $this->coverService->update($university, $command->cover);

        $this->companyRepository->save($company);
        $this->eventBus->publish(...$university->pullDomainEvents());
    }
}
