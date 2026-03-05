<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    User::updateOrCreate(
      ['email' => 'admin@meta.com'],
      [
        'code' => 'ADMIN001',
        'name' => 'Admin',
        'email' => 'admin@meta.com',
        'password' => Hash::make('Admin@1234'),
        'type_user' => 'admin',
        'level' => 1,
        'status' => 1,
      ],
    );
  }
}
