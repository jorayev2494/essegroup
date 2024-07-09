<?php

namespace Project\Domains\Public\Document\Domain\Document\Services\Contracts;

use Project\Domains\Public\Document\Application\Document\Queries\List\Query;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface DocumentServiceInterface
{
    public function list(Query $query): array;

    public function download(string $uuid): StreamedResponse;
}
