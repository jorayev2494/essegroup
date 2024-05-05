<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(ApplicationStatusValueSeeder::class);
        // $this->call(CompanySeeder::class);
    }
}
