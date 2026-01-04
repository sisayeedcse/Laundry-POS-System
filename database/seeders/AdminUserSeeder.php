<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Sohan Laundry Admin',
            'email' => 'sohanlaundry@admin.com',
            'password' => Hash::make('sohal2026laundry'),
            'email_verified_at' => now(),
        ]);
    }
}
