<?php

namespace Project\Domains\Admin\Company\Domain\Company;

use Project\Domains\Admin\Company\Application\Company\Queries\Index\Query;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;

interface CompanyRepositoryInterface
{
    public function getAll(): array;

    public function list(): CompanyCollection;

    public function paginate(Query $httpQuery): array;

    public function findByUuid(Uuid $uuid): ?Company;

    public function findMain(): ?Company;

    public function findByName(Name $name): ?Company;

    public function save(Company $company): void;

    public function delete(Company $company): void;
}
