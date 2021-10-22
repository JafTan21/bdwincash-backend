<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@admin.com'),
            'username' => 'admin',
            'phone' => '123456',
            // 'club_id' => '1',
            'balance' => 100000,
        ])->assignRole('Admin');

        User::create([
            'name' => 'Super admin',
            'email' => 'admin2@admin.com',
            'password' => bcrypt('admin2@admin.com'),
            'username' => 'admin2',
            'phone' => '1234567',
            // 'club_id' => '1',
            'balance' => 100000,
        ])->assignRole('Admin');

        User::create([
            'name' => 'dev',
            'email' => 'dev@admin.com',
            'password' => bcrypt('dev@admin.com'),
            'username' => 'dev',
            'phone' => '123',
            // 'club_id' => '1',
            'balance' => 100000,
        ])->assignRole('User');
    }
}
