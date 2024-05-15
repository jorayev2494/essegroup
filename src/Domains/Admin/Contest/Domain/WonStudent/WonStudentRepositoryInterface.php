<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\WonStudent;

use Project\Domains\Admin\Contest\Application\WonStudent\Queries\Index\Query;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Code;
use Project\Shared\Infrastructure\Repository\Doctrine\Paginator;

interface WonStudentRepositoryInterface
{
    public function paginate(Query $httpQuery): Paginator;

    public function findByCode(Code $code): ?WonStudent;

    public function save(WonStudent $wonStudent): void;
}
