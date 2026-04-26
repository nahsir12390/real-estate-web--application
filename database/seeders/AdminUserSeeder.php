<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@realestate.ng');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@12345');

        $admin = User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Platform Admin',
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'phone' => '+2348000000000',
                'address' => 'Victoria Island, Lagos',
            ]
        );
    }
}
