<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Alias;

use Project\Domains\Admin\University\Application\Alias\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Application\Alias\Queries\List\Query as ListQuery;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface AliasRepositoryInterface
{
    public function paginate(IndexQuery $httpQuery): Paginator;

    public function list(ListQuery $httpQuery): AliasCollection;

    public function findByUuid(Uuid $uuid): ?Alias;

    public function save(Alias $alias): void;

    public function delete(Alias $alias): void;
}
