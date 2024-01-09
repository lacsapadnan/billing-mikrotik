<?php

namespace Database\Seeders;

use App\Enum\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'fullname' => 'Administrator',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'user_type' => UserType::ADMIN,
        ]);
    }
}
