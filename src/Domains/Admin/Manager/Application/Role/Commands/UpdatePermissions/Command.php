<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Role\Commands\UpdatePermissions;

use Project\Shared\Domain\Bus\Command\CommandInterface;

readonly class Command implements CommandInterface
{
    public function __construct(
        public string $uuid,
        public array $permissionIds
    ) { }
}