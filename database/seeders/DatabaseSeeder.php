<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Your admin login. CHANGE THIS PASSWORD before deploying —
        // then change it again from `php artisan tinker` if you ever
        // suspect it leaked.
        User::updateOrCreate(
            ['email' => 'rjm.escaret@gmail.com'],
            [
                'name' => 'Race Jhone Escaret',
                'password' => Hash::make('change-this-password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call(PortfolioSeeder::class);
    }
}
