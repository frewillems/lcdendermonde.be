<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'weblady@lcdendermonde.be')],
            [
                'name' => env('ADMIN_NAME', 'Weblady'),
                'password' => env('ADMIN_PASSWORD', 'password'),
            ],
        );

        $this->call(ContentSeeder::class);
    }
}
