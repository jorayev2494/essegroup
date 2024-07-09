<?php

declare(strict_types=1);

namespace Project\Domains\Student\Contest\Domain\Contest\Services\Contracts;

use Project\Domains\Student\Contest\Application\Contest\Queries\Index\Query as IndexQuery;
use Project\Shared\Domain\ValueObject\UuidValueObject;

interface ContestServiceInterface
{
    public function index(UuidValueObject $studentUud, IndexQuery $query): array;

    public function show(UuidValueObject $studentUud, UuidValueObject $uud): array;
}
