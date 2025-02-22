<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Project\Domains\Admin\Company\Application\Company\Commands\Create\Command;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class CompanySeeder extends Seeder
{
    private const COMPANIES = [
        // [
        //     'name' => 'Esse Elite Group',
        //     'domain' => 'esseelitegroup',
        // ],
        [
            'name' => 'Test Company',
            'domain' => 'test',
        ],
    ];

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {

    }

    public function run(): void
    {
        foreach (self::COMPANIES as $company) {
            $this->commandBus->dispatch(
                new Command(
                    $this->uuidGenerator->generate(),
                    $company['name'],
                    $company['domain'],
                )
            );
        }
    }
}
