<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account is provisioned automatically on first Google login
        // (see GoogleLoginController). This just ensures a row exists so
        // the portfolio doesn't error out before that first login happens.
        // The password is random and unusable — password login is disabled.
        $adminEmail = config('admin.allowed_email');

        if ($adminEmail) {
            User::firstOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => 'Admin',
                    'password' => Hash::make(Str::random(40)),
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->call(PortfolioSeeder::class);
    }
}
