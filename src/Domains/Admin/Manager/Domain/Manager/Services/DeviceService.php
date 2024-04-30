<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\Services;

use Project\Domains\Admin\Authentication\Domain\Device\Device;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
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

    public function handle(Manager $member, string $deviceId): Device
    {
        $uuid = $this->uuidGenerator->generate();
        $refreshToken = $this->tokenGenerator->generate();
        $device = $member->getDevices()->findFirst(static fn (int $index, Device $device): bool => $device->getDeviceId() === $deviceId);

        if ($device === null) {
            $device = Device::fromPrimitives($uuid, $refreshToken, $deviceId);
            $member->addDevice($device);
        } else {
            $device->setRefreshToken($refreshToken);
        }

        return $device;
    }
}
