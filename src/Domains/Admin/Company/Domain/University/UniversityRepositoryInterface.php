<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\University;

use Project\Domains\Admin\Company\Domain\University\ValueObjects\Uuid;

interface UniversityRepositoryInterface
{
    public function get(): Universities;

    public function findByUuid(Uuid $uuid): ?University;

    public function save(University $university): void;
}
