<?php

namespace Database\Seeders;

use Project\Domains\Admin\Manager\Application\Permission\Commands\Create\Command as CreateCommand;
use Illuminate\Database\Seeder;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class ManagerRolePermissionSeeder extends Seeder
{
    private const PERMISSIONS = [
        'country_country' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
    ];

    private readonly array $locales;

    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
        $this->locales = config('app.available_client_translation_locales');
    }

    public function run(): void
    {
        foreach (self::PERMISSIONS as $resource => $permissions) {
            foreach ($permissions as $key => $action) {
                $this->commandBus->dispatch(
                    new CreateCommand(
                        $resource,
                        $action,
                        $this->trans($resource, $action),
                        true
                    )
                );
            }
        }
    }

    private function trans(string $resource, string $action): array
    {
        $result = [];

        foreach ($this->locales as $locale) {
            $result[$locale] = [
                'label' => sprintf(
                    '%s %s %s',
                    ucfirst(str_replace('_', ' -> ', $resource)),
                    ucfirst($action),
                    ucfirst($locale)
                )
            ];
        }

        return $result;
    }
}
