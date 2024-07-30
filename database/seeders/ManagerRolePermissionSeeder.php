<?php

namespace Database\Seeders;

use Project\Domains\Admin\Manager\Application\Permission\Commands\Create\Command as CreateCommand;
use Illuminate\Database\Seeder;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class ManagerRolePermissionSeeder extends Seeder
{
    private const PERMISSIONS = [
        'dashboard' => [
            'index',
//            'create',
            'show',
//            'update',
//            'delete',
        ],
        'country' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'city' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'language' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'announcement' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'contest' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'document' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'company' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'employee' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'student' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'application_status_value' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'alias' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'degree' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'university' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'faculty_name' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'faculty' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'department_name' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'department' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'manager' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'role' => [
            'index',
            'create',
            'show',
            'update',
            'delete',
        ],
        'permission' => [
            'index',
            'show',
            'update',
        ],
        'setting' => [
            'index',
            'about_us',
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
