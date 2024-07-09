<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\University\Application\ApplicationStatusValue\Commands\Create\Command;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class ApplicationStatusValueSeeder extends Seeder
{
    private static $statuses = [
        'New' => [
            'textColor' => '#ffffff',
            'backgroundColor' => '#2d962c',
            'translations' => [],
            'isRequiredNote' => false,
            'isFirst' => true,
        ],
    ];

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator
    ) {
        foreach (self::$statuses as $statusValue => &$status) {
            ['translations' => &$translations] = $status;

            foreach (config('app.available_client_translation_locales') as $locale) {
                $translations[$locale] = [
                    'value' => $statusValue,
                ];
            }
        }
    }

    public function run(): void
    {
        foreach (self::$statuses as $status) {
            $this->commandBus->dispatch(
                new Command(
                    $this->uuidGenerator->generate(),
                    $status['textColor'],
                    $status['backgroundColor'],
                    $status['translations'],
                    $status['isRequiredNote'],
                    $status['isFirst']
                )
            );
        }
    }
}
