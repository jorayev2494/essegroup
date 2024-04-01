<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Degree\Queries\Show;

use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Degree\DegreeTranslate;
use Project\Domains\Admin\University\Domain\Degree\Exceptions\DegreeNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DegreeRepositoryInterface $degreeRepository
    ) {

    }

    public function __invoke(Query $query): array
    {
        $degree = $this->degreeRepository->findByUuid(Uuid::fromValue($query->uuid));

        $degree ?? throw new DegreeNotFoundDomainException();

        return DegreeTranslate::execute($degree)->toArrayWithTranslations();
    }
}
