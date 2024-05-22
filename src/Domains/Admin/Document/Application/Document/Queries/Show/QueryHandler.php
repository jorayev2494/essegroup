<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Application\Document\Queries\Show;

use Project\Domains\Admin\Document\Domain\Document\DocumentRepositoryInterface;
use Project\Domains\Admin\Document\Domain\Document\DocumentTranslate;
use Project\Domains\Admin\Document\Domain\Document\Exceptions\DocumentNotFoundDomainException;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DocumentRepositoryInterface $repository
    ) { }

    public function __invoke(Query $query): array
    {
        $document = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $document ?? throw new DocumentNotFoundDomainException();

        return DocumentTranslate::execute($document)->toArrayWithTranslations();
    }
}
