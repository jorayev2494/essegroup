<?php

namespace Project\Domains\Company\Employee\Domain\Employee\Services\Contracts;

use Project\Domains\Company\Employee\Application\Employee\Queries\Index\Query as IndexQuery;
use Project\Domains\Company\Employee\Application\Employee\Commands\Create\Command as CreateCommand;
use Project\Domains\Company\Employee\Application\Employee\Commands\Update\Command as UpdateCommand;
use Project\Shared\Domain\ValueObject\UuidValueObject;

interface EmployeeServiceInterface
{
    public function index(UuidValueObject $companyUuid, IndexQuery $query): array;

    public function create(UuidValueObject $companyUuid, CreateCommand $command): void;

    public function show(UuidValueObject $companyUuid, UuidValueObject $uuid): array;

    public function update(UpdateCommand $command): void;

    public function delete(UuidValueObject $companyUuid, UuidValueObject $uuid): void;
}
