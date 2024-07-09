<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Applicaiton\StaticPage\Queries\Show;

use Project\Domains\Admin\StaticPage\Domain\StaticPage\Exceptions\StaticPageNotFoundDomainException;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageRepositoryInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\StaticPageTranslate;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StaticPageRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        $foundStaticPage = $this->repository->findBySlug(Slug::fromValue($query->slug));

        $foundStaticPage ?? throw new StaticPageNotFoundDomainException();

        return StaticPageTranslate::execute($foundStaticPage)->toArrayWithTranslations();
    }
}
