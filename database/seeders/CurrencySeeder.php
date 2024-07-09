<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\Currency\Application\Currency\Commands\Create\Command;
use Project\Infrastructure\Generators\Contracts\UuidGeneratorInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class CurrencySeeder extends Seeder
{
    private array $currencies = [
        [
            'value' => '1.00',
            'code' => 'USD',
            'symbol' => '$',
            'description' => 'This main currency',
            'is_main' => true,
        ]
    ];

    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly CommandBusInterface $commandBus
    ) { }

    public function run(): void
    {
        foreach ($this->currencies as $currency) {
            $this->commandBus->dispatch(
                new Command(
                    $this->uuidGenerator->generate(),
                    $currency['value'],
                    $currency['code'],
                    $currency['symbol'],
                    $currency['is_main'],
                    $currency['description'],
                )
            );
        }
    }
}
