<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Device;

use Project\Domains\Company\Authentication\Domain\Device\Device;
use Project\Domains\Company\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Shared\Infrastructure\Repository\Contracts\BaseAdminEntityRepository;

class DeviceRepository extends BaseAdminEntityRepository implements DeviceRepositoryInterface
{
    protected function getEntity(): string
    {
        return Device::class;
    }

    public function findByRefreshToken(string $refreshToken): ?Device
    {
        return $this->entityRepository->findOneBy(['refreshToken' => $refreshToken]);
    }

    public function save(Device $device): void
    {
        $this->entityRepository->getEntityManager()->persist($device);
        $this->entityRepository->getEntityManager()->flush();
    }
}
