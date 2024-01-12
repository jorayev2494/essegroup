<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    private array $admins = [
        'admin@gmail.com',
        'admin2@gmail.com',
    ];

    private readonly string $password;

    function __construct()
    {
        $this->password = bcrypt('12345Secret_');
    }

    public function run(): void
    {
        foreach ($this->admins as $key => $email) {
            Admin::factory([
                'email' => $email,
                'password' => $this->password,
            ])->create();
        }
    }
}
