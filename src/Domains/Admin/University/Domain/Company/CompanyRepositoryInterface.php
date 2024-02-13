<?php

namespace Project\Domains\Admin\University\Domain\Company;

use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Name;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Domain;

interface CompanyRepositoryInterface
{
    public function existsByUuid(Uuid $uuid): bool;

    public function getAll(): array;

    public function findByUuid(Uuid $uuid): ?Company;

    public function findByName(Name $name): ?Company;

    public function findByDomain(Domain $domain): ?Company;

    public function save(Company $company): void;

    public function delete(Company $company): void;
}
