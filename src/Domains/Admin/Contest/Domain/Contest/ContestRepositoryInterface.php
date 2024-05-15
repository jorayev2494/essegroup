<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\Contest;

use Project\Domains\Admin\Contest\Application\Contest\Queries\Index\Query;
use Project\Domains\Admin\Contest\Domain\Contest\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface ContestRepositoryInterface
{
    public function paginate(Query $httpQuery): Paginator;

    public function findByUuid(Uuid $uuid): ?Contest;

    public function save(Contest $contest): void;

    public function delete(Contest $contest): void;
}
