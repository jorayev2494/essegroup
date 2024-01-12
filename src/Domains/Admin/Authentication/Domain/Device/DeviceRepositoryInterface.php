<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Device;

interface DeviceRepositoryInterface
{
    public function findByRefreshToken(string $refreshToken): ?Device;

    public function save(Device $device): void;
}
