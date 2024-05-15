<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\Index\Query as IndexQuery;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface StatusValueRepositoryInterface
{
    public function paginate(IndexQuery $httpQuery): Paginator;

    public function list(): StatusValueCollection;

    public function findByUuid(StatusValueUuid $uuid): ?StatusValue;

    public function findManyByUuids(array $uuids): StatusValueCollection;

    public function findFirst(): ?StatusValue;

    public function save(StatusValue $statusItem): void;

    public function delete(StatusValue $statusItem): void;
}
