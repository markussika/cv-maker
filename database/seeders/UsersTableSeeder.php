<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Avery Johnson',
                'email' => 'avery@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'provider_name' => null,
                'provider_id' => null,
                'avatar_url' => 'https://avatars.dicebear.com/api/initials/Avery%20Johnson.svg',
                'remember_token' => Str::random(20),
            ],
            [
                'name' => 'Bianca Singh',
                'email' => 'bianca@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'provider_name' => null,
                'provider_id' => null,
                'avatar_url' => 'https://avatars.dicebear.com/api/initials/Bianca%20Singh.svg',
                'remember_token' => Str::random(20),
            ],
            [
                'name' => 'Carlos Mendes',
                'email' => 'carlos@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'provider_name' => null,
                'provider_id' => null,
                'avatar_url' => 'https://avatars.dicebear.com/api/initials/Carlos%20Mendes.svg',
                'remember_token' => Str::random(20),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
