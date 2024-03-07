<?php

namespace Project\Domains\Company\Authentication\Domain\Company;

interface CompanyRepositoryInterface
{
    public function findByUuid(string $uuid): ?Company;

    public function save(Company $company): void;

    public function delete(Company $company): void;
}
