<?php

declare(strict_types=1);

namespace Project\Domains\Company\Student\Domain\Student\Services\Contracts;

use Project\Domains\Company\Student\Application\Student\Commands\Create\Command;
use Project\Domains\Company\Student\Application\Student\Queries\Index\Query;
use Project\Shared\Domain\ValueObject\UuidValueObject;

interface StudentServiceInterface
{
    public function index(UuidValueObject $companyUuid, Query $query): array;

    public function create(UuidValueObject $companyUuid, Command $command): void;

    public function show(UuidValueObject $companyUuid, UuidValueObject $uuid): array;

    public function delete(UuidValueObject $companyUuid, UuidValueObject $uuid): void;
}
