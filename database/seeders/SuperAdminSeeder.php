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
    User::updateOrCreate(
      [
          'user_name' => 'Super Admin'
          ,
      ],
      [
          'email' => 'superadmin@gmail.com',
          'user_name' => 'Super Admin',
          'role' => 'super_admin',
          'password' => Hash::make('admin@123'),
          'updated_at' => now(),
      ]
    );
  }
}
