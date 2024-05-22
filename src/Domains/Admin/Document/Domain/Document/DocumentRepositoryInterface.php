<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document;

use Project\Domains\Admin\Document\Application\Document\Queries\Index\Query;
use Project\Domains\Admin\Document\Application\Document\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Document\Domain\Document\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface DocumentRepositoryInterface
{
    public function paginate(Query $httpQuery): Paginator;

    public function list(ListQuery $httpQuery): DocumentCollection;

    public function findByUuid(Uuid $uuid): ?Document;

    public function save(Document $document): void;

    public function delete(Document $document): void;
}
