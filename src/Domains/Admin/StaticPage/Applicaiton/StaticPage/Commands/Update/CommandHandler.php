<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Commands\Update;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\Exceptions\StaticPageNotFoundDomainException;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts\CoverServiceInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageRepositoryInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;
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
        $staticPage = $this->repository->findBySlug(Slug::fromValue($command->slug));

        $staticPage ?? throw new StaticPageNotFoundDomainException();

        $this->coverService->update($staticPage, $command->cover);
        $this->translationColumnService->addTranslations($staticPage, $command->translations);

        $this->repository->save($staticPage);
    }
}
