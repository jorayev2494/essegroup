<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Applications\Language\Queries\Show;

use Project\Domains\Admin\Language\Domain\Language\Exceptions\LanguageNotFoundDomainException;
use Project\Domains\Admin\Language\Domain\Language\LanguageRepositoryInterface;
use Project\Domains\Admin\Language\Domain\Language\LanguageTranslate;
use Project\Domains\Admin\Language\Domain\Language\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
       private LanguageRepositoryInterface $repository
    ) {

    }

    public function __invoke(Query $query): array
    {
        $language = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $language ?? throw new LanguageNotFoundDomainException();

        return LanguageTranslate::execute($language)->toArrayWithTranslations();
    }
}