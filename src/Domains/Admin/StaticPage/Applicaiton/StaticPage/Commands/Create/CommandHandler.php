<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Commands\Create;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\Exceptions\TheSlugAlreadyExistsDomainException;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPage;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageRepositoryInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private StaticPageRepositoryInterface $repository,
        private TranslationColumnServiceInterface $translationColumnService,
        private CoverServiceInterface $coverService
    ) { }

    public function __invoke(Command $command): void
    {
        $foundStaticPage = $this->repository->findBySlug(Slug::fromValue($command->slug));

        if ($foundStaticPage !== null) {
            throw new TheSlugAlreadyExistsDomainException();
        }

        $staticPage = StaticPage::create(
            Uuid::fromValue($command->uuid),
            Slug::fromValue($command->slug)
        );

        $this->coverService->upload($staticPage, $command->cover);
        $this->translationColumnService->addTranslations($staticPage, $command->translations);

        $this->repository->save($staticPage);
    }
}
