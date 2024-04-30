<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    private array $admins = [
        [
            'first_name' => 'Admin',
            'last_name' => 'Adminov',
            'email' => 'admin@gmail.com',
            'password' => '$2y$12$as4u2neF.2HgvMn/PshWX.f7rdVDVqSFETKTklrSVCz9V5C9AiGUi',
        ],
        [
            'first_name' => 'Admin2',
            'last_name' => 'Adminov2',
            'email' => 'admin2@gmail.com',
            'password' => '$2y$12$as4u2neF.2HgvMn/PshWX.f7rdVDVqSFETKTklrSVCz9V5C9AiGUi',
        ],
    ];

    public function run(): void
    {
        $createdAt = new \DateTimeImmutable();

        foreach ($this->admins as $data) {
            Admin::factory(array_merge(
                $data,
                [
                    // 'created_at' => $createdAt,
                    // 'updated_at' => $createdAt,
                ]
            ))->create();
        }
    }
}
