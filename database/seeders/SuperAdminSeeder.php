<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'user_name' => 'Super Admin',
            // 'email' => 'superadmin@example.com',
            'role' => 'super_admin',
            'password' => Hash::make('admin@123'),  // always hash password
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
