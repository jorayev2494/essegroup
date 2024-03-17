<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Domain\Manager;

use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\CompanyUuid;
use Project\Domains\Company\Manager\Domain\Manager\ValueObjects\Uuid;

interface ManagerRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Manager;

    public function findManyByCompanyUuid(CompanyUuid $companyUuid): ManagerCollection;

    public function save(Manager $manager): void;

    public function delete(Manager $manager): void;
}
