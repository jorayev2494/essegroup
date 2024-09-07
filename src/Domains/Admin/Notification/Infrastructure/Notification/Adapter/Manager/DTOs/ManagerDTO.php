<?php

namespace Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs;

use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\VOs\ManagerAvatar;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\VOs\ManagerFullName;
use Project\Domains\Admin\Notification\Infrastructure\Notification\Adapter\Manager\DTOs\VOs\ManagerUuid;

readonly class ManagerDTO
{
    private function __construct(
        public ManagerUuid $uuid,
        public ManagerFullName $fullName,
        public ManagerAvatar $avatar
    ) { }

    public static function make(ManagerUuid $uuid, ManagerFullName $fullName, ManagerAvatar $avatar): self
    {
        return new self($uuid, $fullName, $avatar);
    }

    public static function makeFromArray(array $data): self
    {
        [
            'uuid' => $uuid,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'avatar' => $avatar,
        ] = $data;

        return new self(
            ManagerUuid::fromValue($uuid),
            ManagerFullName::fromValues($firstName, $lastName),
            ManagerAvatar::fromValue($avatar)
        );
    }
}