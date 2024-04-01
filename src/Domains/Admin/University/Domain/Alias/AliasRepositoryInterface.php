<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Alias;

use Project\Domains\Admin\University\Application\Alias\Queries\Index\Query;
use Project\Domains\Admin\University\Domain\Alias\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface AliasRepositoryInterface
{
    public function paginate(Query $httpQuery): Paginator;

    public function findByUuid(Uuid $uuid): ?Alias;

    public function save(Alias $alias): void;

    public function delete(Alias $alias): void;
}
