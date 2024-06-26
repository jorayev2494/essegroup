<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Presentation\Http\API\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Student\Application\Queries\ArchiveDocuments\Query as ArchiveDocumentsQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class ActionController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function archiveDocuments(string $uuid): StreamedResponse
    {
        return $this->queryBus->ask(
            new ArchiveDocumentsQuery($uuid)
        );
    }
}
