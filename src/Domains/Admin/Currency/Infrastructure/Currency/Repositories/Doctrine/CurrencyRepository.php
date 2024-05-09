<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Infrastructure\Currency\Repositories\Doctrine;

use Project\Domains\Admin\Currency\Application\Currency\Queries\List\Query as ListQuery;
use Project\Domains\Admin\Currency\Domain\Currency\Currency;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyCollection;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class CurrencyRepository extends BaseAdminEntityRepository implements CurrencyRepositoryInterface
{
    protected function getEntity(): string
    {
        return Currency::class;
    }

    public function list(ListQuery $httpQuery): CurrencyCollection
    {
        return new CurrencyCollection(
            $this->entityRepository->createQueryBuilder('c')
                ->getQuery()
                ->getResult()
        );
    }

    public function findByUuid(Uuid $uuid): ?Currency
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Currency $currency): void
    {
        $this->entityRepository->getEntityManager()->persist($currency);
        $this->entityRepository->getEntityManager()->flush();
    }
}
