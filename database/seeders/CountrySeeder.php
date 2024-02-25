<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Project\Domains\Admin\Country\Application\Country\Commands\Create\Command;
use Project\Domains\Admin\Country\Domain\Country\ValueObjects\CompanyUuid;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class CountrySeeder extends Seeder
{

    private const COUNTRIES = [
        [
            'value' => 'ukraine',
            'iso' => 'ukr',
        ],
        [
            'value' => 'turkie',
            'iso' => 'trk',
        ],
        [
            'value' => 'turkmenistan',
            'iso' => 'tkm',
        ],
    ];

    public function __construct(
        private readonly CommandBusInterface $commandBus
    )
    {

    }

    public function run(): void
    {
//        $this->command->alert('Company please');
//        $cUuid = $this->command->ask('Company uuid: ');
//
//        if ($companyUuid = CompanyUuid::fromValue($cUuid)) {
//            foreach (self::COUNTRIES as $country) {
//                $this->commandBus->dispatch(
//                    new Command(
//                        $country['value'],
//                        $country['iso'],
//                        $companyUuid->value,
//                        true
//                    )
//                );
//            }
//        }

    }
}
