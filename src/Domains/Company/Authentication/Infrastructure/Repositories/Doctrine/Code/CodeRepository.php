<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Code;

use Project\Domains\Company\Authentication\Domain\Code\Code;
use Project\Domains\Company\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

final class CodeRepository extends BaseAdminEntityRepository implements CodeRepositoryInterface
{
    protected function getEntity(): string
    {
        return Code::class;
    }

    public function findByToken(string $token): ?Code
    {
        return $this->entityRepository->findOneBy(['value' => $token]);
    }

    public function save(Code $code): void
    {
        $this->entityRepository->getEntityManager()->persist($code);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Code $code): void
    {
        $this->entityRepository->getEntityManager()->remove($code);
        $this->entityRepository->getEntityManager()->flush();
    }
}
