<?php

declare(strict_types=1);

namespace Project\Domains\Public\Document\Domain\Document\Services;

use Project\Domains\Public\Document\Application\Document\Queries\List\Query;
use Project\Domains\Public\Document\Domain\Document\Services\Contracts\DocumentServiceInterface;
use Project\Domains\Admin\Document\Application\Document\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Document\Application\Document\Queries\Download\Query as DownloadQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class DocumentService implements DocumentServiceInterface
{
    public function list(Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(ListQuery::makeFromArray($query->toArray()));
    }

    public function download(string $uuid): StreamedResponse
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(new DownloadQuery($uuid));
    }
}
