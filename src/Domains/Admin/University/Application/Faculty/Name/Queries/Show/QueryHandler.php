<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Faculty\Name\Queries\Show;

use Project\Domains\Admin\University\Domain\Faculty\Name\Exception\FacultyNameNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameRepositoryInterface;
use Project\Domains\Admin\University\Domain\Faculty\Name\FacultyNameTranslate;
use Project\Domains\Admin\University\Domain\Faculty\Name\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FacultyNameRepositoryInterface $nameRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        $name = $this->nameRepository->findByUuid(Uuid::fromValue($query->uuid));

        $name ?? throw new FacultyNameNotFoundDomainException();

        return FacultyNameTranslate::execute($name)->toArrayWithTranslations();
    }
}
