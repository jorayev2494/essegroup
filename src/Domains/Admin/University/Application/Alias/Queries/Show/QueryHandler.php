<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Alias\Queries\Show;

use Project\Domains\Admin\University\Domain\Alias\AliasRepositoryInterface;
use Project\Domains\Admin\University\Domain\Alias\AliasTranslate;
use Project\Domains\Admin\University\Domain\Alias\Exceptions\AliasNotFoundExceptionDomainException;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AliasRepositoryInterface $aliasRepository
    )
    {

    }

    public function __invoke(Query $query): array
    {
        $alias = $this->aliasRepository->findByUuid(Uuid::fromValue($query->uuid));

        $alias ?? throw new AliasNotFoundExceptionDomainException();

        return AliasTranslate::execute($alias)->toArrayWithTranslations();
    }
}
