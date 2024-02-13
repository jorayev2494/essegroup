<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Infrastructure\Repositories\Doctrine\University;

use Project\Domains\Admin\University\Domain\University\UniversityCollection;
use Project\Domains\Admin\University\Domain\University\University;
use Project\Domains\Admin\Company\Domain\University\UniversityRepositoryInterface;
use Project\Domains\Admin\Company\Domain\University\UniversityTranslate;
use Project\Domains\Admin\University\Domain\University\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class UniversityRepository extends BaseAdminEntityRepository implements UniversityRepositoryInterface
{

    #[\Override]
    protected function getEntity(): string
    {
        return University::class;
    }

    public function get(): UniversityCollection
    {
        return (new UniversityCollection($this->entityRepository->findAll()))->translateItems();
    }

    #[\Override]
    public function findByUuid(Uuid $uuid): ?University
    {
        /** @var University $university */
        $university = $this->entityRepository->find($uuid);

        return UniversityTranslate::execute($university);
    }

    #[\Override]
    public function save(University $university): void
    {
        $this->entityRepository->getEntityManager()->persist($university);
        $this->entityRepository->getEntityManager()->flush();
    }
}
