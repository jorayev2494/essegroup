<?php

namespace Project\Domains\Public\University\Infrastructure\Repositories\Doctrine\University;

use Project\Domains\Admin\University\Domain\University\UniversityTranslate;
use Project\Domains\Admin\University\Domain\Company\ValueObjects\Uuid;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\University\Domain\University\UniversityCollection;
use Project\Domains\Public\University\Domain\University\UniversityRepositoryInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class UniversityRepository extends BaseAdminEntityRepository implements UniversityRepositoryInterface
{

    #[\Override]
    protected function getEntity(): string
    {
        return University::class;
    }

    public function index(): UniversityCollection
    {
        return new UniversityCollection($this->entityRepository->findAll());
    }

    public function findByUuid(Uuid $uuid): ?University
    {
        return UniversityTranslate::execute($this->entityRepository->find($uuid));
    }
}
