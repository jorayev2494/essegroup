<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\Show;

use Project\Domains\Admin\University\Domain\Application\Exceptions\StatusValueNotFoundDomainException;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\StatusValueTranslate;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StatusValueRepositoryInterface $statusValueRepository
    ) { }

    public function __invoke(Query $query): array
    {
        $statusValue = $this->statusValueRepository->findByUuid(StatusValueUuid::fromValue($query->uuid));

        $statusValue ?? throw new StatusValueNotFoundDomainException();

        return StatusValueTranslate::execute($statusValue)->toArrayWithTranslations();
    }
}
