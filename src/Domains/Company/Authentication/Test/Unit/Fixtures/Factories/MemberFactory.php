<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Test\Unit\Fixtures\Factories;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;

class MemberFactory
{
    public const UUID = '9b06d25d-bdb2-4d38-96dd-07c017ae5ee7';

    public const FIRST_NAME = 'Alex';

    public const LAST_NAME = 'Alexeev';

    public const EMAIL = 'admin@gmail.com';

    public const PASSWORD = '12345Secret_';

    public static function make(
        string $uuid = null,
        string $email = null,
        string $password = null
    ): Manager
    {
        return Manager::fromPrimitives(
            $uuid ?? self::UUID,
                $fistName ?? self::FIRST_NAME,
                $lastName ?? self::LAST_NAME,
            $email ?? self::EMAIL,
            $password ?? self::PASSWORD
        );
    }
}
