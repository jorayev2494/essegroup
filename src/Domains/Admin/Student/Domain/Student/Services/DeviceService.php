<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Services;

use Project\Domains\Admin\Student\Domain\Student\Student;
use Project\Domains\Student\Authentication\Domain\Device\Device;
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

    public function handle(Student $student, string $deviceId): Device
    {
        $uuid = $this->uuidGenerator->generate();
        $refreshToken = $this->tokenGenerator->generate();
        $device = $student->getDevices()->findFirst(static fn (int $index, Device $device): bool => $device->getDeviceId() === $deviceId);

        if ($device === null) {
            $device = Device::fromPrimitives($uuid, $refreshToken, $deviceId);
            $student->addDevice($device);
        } else {
            $device->setRefreshToken($refreshToken);
        }

        return $device;
    }
}
