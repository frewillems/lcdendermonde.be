<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => config('club.admin_email')],
            [
                'name' => config('club.admin_name'),
                'password' => config('club.admin_password'),
            ],
        );

        $this->call(ContentSeeder::class);
    }
}
