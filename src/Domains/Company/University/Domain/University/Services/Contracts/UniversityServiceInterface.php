<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Domain\University\Services\Contracts;

interface UniversityServiceInterface
{
    public function index(string $companyUuid): array;
}
