<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Test\Unit\Fixtures\Factories;

use Project\Domains\Admin\Authentication\Domain\Device\Device;

class DeviceFactory
{
    public const UUID = '9b06d25d-bdb2-4d38-96dd-07c017ae5ee7';

    public const REFRESH_TOKEN = '8ee8ee74486b1eb8a6062247b5a1114d';

    public const DEVICE_ID = 'device-id';

    public static function make(
        string $uuid = null,
        string $refreshToken = null,
        string $deviceId = null
    ): Device
    {
        return Device::fromPrimitives(
            $uuid ?? self::UUID,
            $refreshToken ?? self::REFRESH_TOKEN,
            $deviceId ?? self::DEVICE_ID
        );
    }
}
