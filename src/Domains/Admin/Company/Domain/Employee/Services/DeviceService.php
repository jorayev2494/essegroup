<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Employee\Services;

use Project\Domains\Admin\Company\Domain\Employee\Employee;
use Project\Domains\Company\Authentication\Domain\Device\Device;
use Project\Infrastructure\Generators\Contracts\TokenGeneratorInterface;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;

class DeviceService
{
    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly TokenGeneratorInterface $tokenGenerator,
    )
    {

    }

    public function handle(Employee $employee, string $deviceId): Device
    {
        $uuid = $this->uuidGenerator->generate();
        $refreshToken = $this->tokenGenerator->generate();
        $device = $employee->getDevices()->findFirst(static fn (int $index, Device $device): bool => $device->getDeviceId() === $deviceId);

        if ($device === null) {
            $device = Device::fromPrimitives($uuid, $refreshToken, $deviceId);
            $employee->addDevice($device);
        } else {
            $device->setRefreshToken($refreshToken);
        }

        return $device;
    }
}
