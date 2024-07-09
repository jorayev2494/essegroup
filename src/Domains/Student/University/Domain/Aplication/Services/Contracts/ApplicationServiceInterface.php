<?php

declare(strict_types=1);

namespace Project\Domains\Student\University\Domain\Aplication\Services\Contracts;

use Project\Domains\Student\University\Application\Application\Commands\Create\Command as CreateCommand;
use Project\Domains\Student\University\Application\Application\Commands\Update\Command as UpdateCommand;
use Project\Domains\Student\University\Application\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Student\University\Application\Application\Queries\ByStudentUuid\Query as ByStudentUuidQuery;
use Project\Domains\Student\University\Application\Application\Queries\Show\Query as ShowQuery;
use Project\Shared\Domain\ValueObject\UuidValueObject;

interface ApplicationServiceInterface
{
    public function index(UuidValueObject $studentUuid, IndexQuery $query): array;

    public function paginateByStudentUuid(ByStudentUuidQuery $query): array;

    public function create(CreateCommand $command): void;

    public function show(ShowQuery $query): array;

    public function update(UpdateCommand $command): void;
}
