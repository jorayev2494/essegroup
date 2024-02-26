<?php

namespace Project\Domains\Admin\Company\Domain\Company;

use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Domain;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;

interface CompanyRepositoryInterface
{
    public function getAll(): array;

    public function list(): CompanyCollection;

    public function paginate(BaseHttpQueryParams $baseHttpQueryParams): array;

    public function findByUuid(Uuid $uuid): ?Company;

    public function findByName(Name $name): ?Company;

    public function findByDomain(Domain $domain): ?Company;

    public function save(Company $company): void;

    public function delete(Company $company): void;
}
