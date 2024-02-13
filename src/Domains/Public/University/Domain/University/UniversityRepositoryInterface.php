<?php

namespace Project\Domains\Public\University\Domain\University;

use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityCollection;

interface UniversityRepositoryInterface
{
    public function index(): UniversityCollection;

    public function findByUuid(Uuid $uuid): ?University;
}
