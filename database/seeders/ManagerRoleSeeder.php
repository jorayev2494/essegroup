<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\Manager\Application\Role\Commands\Create\Command as CreateCommand;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class ManagerRoleSeeder extends Seeder
{
    private const ROLES = [
        'admin',
        'manager',
    ];

    private readonly array $locales;

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator
    ) {
        $this->locales = config('app.available_client_translation_locales');
    }

    public function run(): void
    {
        foreach (self::ROLES as $role) {
            $this->commandBus->dispatch(
                new CreateCommand(
                    $this->uuidGenerator->generate(),
                    $this->trans($role),
                    true
                )
            );
        }
    }

    private function trans(string $role): array
    {
        $result = [];

        foreach ($this->locales as $locale) {
            $result[$locale] = [
                'name' => sprintf(
                    '%s %s',
                    ucfirst($role),
                    ucfirst($locale)
                )
            ];
        }

        return $result;
    }
}
