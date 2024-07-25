<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ApplicationStatusValueSeeder::class);
        $this->call(StaticPageSeeder::class);
        // $this->call(CompanySeeder::class);
        $this->call(ManagerRoleSeeder::class);
        $this->call(ManagerRolePermissionSeeder::class);
    }
}
